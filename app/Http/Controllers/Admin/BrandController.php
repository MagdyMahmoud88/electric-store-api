<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BrandController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  الثوابت
    // ══════════════════════════════════════════════════════════════

    /** الحد الأقصى لحجم الـ IDs في Bulk actions لحماية الـ DB */
    private const BULK_LIMIT = 100;

    /** مسار تخزين الصور */
    private const LOGO_DISK = 'public';
    private const LOGO_PATH = 'brands';

    // ══════════════════════════════════════════════════════════════
    //  CRUD العادي
    // ══════════════════════════════════════════════════════════════

    public function index(Request $request): View
    {
        $brands = Brand::query()
            ->when(
                $request->filled('search'),
                fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->when(
                $request->filled('status'),
                fn($q) => $q->where('is_active', (bool) $request->status)
            )
            ->ordered()
            ->withCount('products')
            ->paginate(12)
            ->withQueryString();

        return view('admin.brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['slug']      = $this->uniqueSlug(
            $data['slug'] ? Str::slug($data['slug']) : Str::slug($data['name'])
        );
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadLogo($request);
        }

        Brand::create($data);

        return redirect()->route('admin.brands.index')
            ->with('success', 'تم إضافة الماركة بنجاح');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand): RedirectResponse
    {
        $data = $request->validated();

        $data['slug']      = $this->uniqueSlug(
            $data['slug'] ? Str::slug($data['slug']) : Str::slug($data['name']),
            $brand->id
        );
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $this->deleteLogo($brand->logo);
            $data['logo'] = $this->uploadLogo($request);
        }

        $brand->update($data);

        return redirect()->route('admin.brands.index')
            ->with('success', 'تم تحديث الماركة بنجاح');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        if ($brand->products()->exists()) {
            return back()->with('error', 'لا يمكن حذف الماركة لأن لها منتجات مرتبطة');
        }

        $this->deleteLogo($brand->logo);
        $brand->delete();

        return back()->with('success', 'تم حذف الماركة بنجاح');
    }

    public function toggleStatus(Brand $brand): RedirectResponse
    {
        $brand->update(['is_active' => ! $brand->is_active]);

        $statusLabel = $brand->is_active ? 'تفعيل' : 'إخفاء';

        return back()->with('success', "تم {$statusLabel} الماركة بنجاح");
    }

    // ══════════════════════════════════════════════════════════════
    //  Bulk Actions
    // ══════════════════════════════════════════════════════════════

    /**
     * POST /admin/brands/bulk-activate
     */
    public function bulkActivate(Request $request): RedirectResponse
    {
        $ids = $this->validateBulkIds($request);

        if ($ids === null) {
            return back()->with('error', 'لم يتم تحديد أي ماركات صالحة.');
        }

        $count = Brand::whereIn('id', $ids)->update(['is_active' => true]);

        return back()->with('success', "تم تفعيل {$count} ماركة بنجاح.");
    }

    /**
     * POST /admin/brands/bulk-hide
     */
    public function bulkHide(Request $request): RedirectResponse
    {
        $ids = $this->validateBulkIds($request);

        if ($ids === null) {
            return back()->with('error', 'لم يتم تحديد أي ماركات صالحة.');
        }

        $count = Brand::whereIn('id', $ids)->update(['is_active' => false]);

        return back()->with('success', "تم إخفاء {$count} ماركة بنجاح.");
    }

    /**
     * DELETE /admin/brands/bulk-destroy
     *
     * الترتيب الصحيح:
     *  1. التحقق من صحة الـ IDs
     *  2. التحقق من وجود منتجات مرتبطة (قبل أي حذف)
     *  3. حذف الصور من الـ storage
     *  4. حذف الـ brands من قاعدة البيانات
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $this->validateBulkIds($request);

        if ($ids === null) {
            return back()->with('error', 'لم يتم تحديد أي ماركات صالحة.');
        }

        // ① الأول: تحقق من المنتجات المرتبطة قبل أي حذف
        $blockedNames = Brand::whereIn('id', $ids)
            ->whereHas('products')
            ->pluck('name');

        if ($blockedNames->isNotEmpty()) {
            return back()->with('error',
                'هذه الماركات لها منتجات ولا يمكن حذفها: ' . $blockedNames->join('، ')
            );
        }

        // ② بعدين: احذف الصور من الـ storage
        Brand::whereIn('id', $ids)->get()
            ->each(fn($brand) => $this->deleteLogo($brand->logo));

        // ③ أخيراً: احذف من قاعدة البيانات
        $count = Brand::whereIn('id', $ids)->delete();

        return back()->with('success', "تم حذف {$count} ماركة بنجاح.");
    }

    // ══════════════════════════════════════════════════════════════
    //  Helper Methods
    // ══════════════════════════════════════════════════════════════

    /**
     * توليد slug فريد مع تجنب التكرار
     */
    private function uniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $query = Brand::where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if (! $query->exists()) {
            return $slug;
        }

        $counter      = 2;
        $originalSlug = $slug;

        while (
        Brand::where('slug', "{$originalSlug}-{$counter}")
            ->where('id', '!=', $excludeId ?: 0)
            ->exists()
        ) {
            $counter++;
        }

        return "{$originalSlug}-{$counter}";
    }

    /**
     * رفع اللوجو وإرجاع المسار
     */
    private function uploadLogo(Request $request): string
    {
        return $request->file('logo')->store(self::LOGO_PATH, self::LOGO_DISK);
    }

    /**
     * حذف اللوجو من الـ storage
     */
    private function deleteLogo(?string $logoPath): void
    {
        if ($logoPath) {
            Storage::disk(self::LOGO_DISK)->delete($logoPath);
        }
    }

    /**
     * التحقق من صحة الـ IDs القادمة من Bulk requests
     * ترجع null لو الـ IDs فاضية أو تجاوزت الحد الأقصى
     */
    private function validateBulkIds(Request $request): ?array
    {
        $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = collect(explode(',', $request->ids))
            ->map(fn($id) => trim($id))
            ->filter(fn($id) => is_numeric($id))
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values()
            ->toArray();

        if (empty($ids) || count($ids) > self::BULK_LIMIT) {
            return null;
        }

        return $ids;
    }
}
