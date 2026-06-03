<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private const BULK_LIMIT = 100;
    private const STATUSES   = ['active', 'inactive'];

    // ══════════════════════════════════════════════════════════
    //  index
    // ══════════════════════════════════════════════════════════

    public function index(Request $request): View
    {
        $categories = Category::query()
            ->when(
                $request->filled('search'),
                fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->when(
                $request->filled('status') && in_array($request->status, self::STATUSES),
                fn($q) => $q->where('status', $request->status)
            )
            ->withCount('products')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total'    => Category::count(),
            'active'   => Category::where('status', 'active')->count(),
            'inactive' => Category::where('status', 'inactive')->count(),
            'products' => \App\Models\Product::count(),
        ];

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    // ══════════════════════════════════════════════════════════
    //  create
    // ══════════════════════════════════════════════════════════

    public function create(): View
    {
        return view('admin.categories.create');
    }

    // ══════════════════════════════════════════════════════════
    //  store
    // ══════════════════════════════════════════════════════════

    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // ✅ لو icon فاضي → شيله عشان الـ DB يستخدم default('📦')
        if (empty($data['icon'])) {
            unset($data['icon']);
        }

        // ✅ لو color فاضي → شيله عشان الـ DB يستخدم default('icon-blue')
        if (empty($data['color'])) {
            unset($data['color']);
        }

        // ✅ slug يتولد تلقائياً من name لو مجاش
        if (empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['name']));
        } else {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['slug']));
        }

        $data['status'] = $data['status'] ?? 'active';

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    // ══════════════════════════════════════════════════════════
    //  show
    // ══════════════════════════════════════════════════════════

    public function show(Category $category): View
    {
        $category->loadCount('products');
        $category->load(['products' => fn($q) => $q->latest()->take(10)]);

        return view('admin.categories.show', compact('category'));
    }

    // ══════════════════════════════════════════════════════════
    //  edit
    // ══════════════════════════════════════════════════════════

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    // ══════════════════════════════════════════════════════════
    //  update
    // ══════════════════════════════════════════════════════════

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        // ✅ لو icon فاضي → استخدم القيمة القديمة
        if (empty($data['icon'])) {
            unset($data['icon']);
        }

        // ✅ لو color فاضي → استخدم القيمة القديمة
        if (empty($data['color'])) {
            unset($data['color']);
        }

        // ✅ slug
        if (empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['name']), $category->id);
        } else {
            $slug = Str::slug($data['slug']);
            $data['slug'] = ($slug !== $category->slug)
                ? $this->uniqueSlug($slug, $category->id)
                : $slug;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    // ══════════════════════════════════════════════════════════
    //  destroy
    // ══════════════════════════════════════════════════════════

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'لا يمكن حذف القسم لأن له منتجات مرتبطة');
        }

        $category->delete();

        return back()->with('success', 'تم حذف القسم بنجاح');
    }

    // ══════════════════════════════════════════════════════════
    //  toggleStatus
    // ══════════════════════════════════════════════════════════

    public function toggleStatus(Category $category): RedirectResponse
    {
        $newStatus = $category->status === 'active' ? 'inactive' : 'active';
        $category->update(['status' => $newStatus]);

        $label = $newStatus === 'active' ? 'تفعيل' : 'إخفاء';

        return back()->with('success', "تم {$label} القسم بنجاح");
    }

    // ══════════════════════════════════════════════════════════
    //  Bulk Actions
    // ══════════════════════════════════════════════════════════

    public function bulkActivate(Request $request): RedirectResponse
    {
        $ids = $this->validateBulkIds($request);

        if ($ids === null) {
            return back()->with('error', 'لم يتم تحديد أي أقسام صالحة.');
        }

        $count = Category::whereIn('id', $ids)->update(['status' => 'active']);

        return back()->with('success', "تم تفعيل {$count} قسم بنجاح.");
    }

    public function bulkHide(Request $request): RedirectResponse
    {
        $ids = $this->validateBulkIds($request);

        if ($ids === null) {
            return back()->with('error', 'لم يتم تحديد أي أقسام صالحة.');
        }

        $count = Category::whereIn('id', $ids)->update(['status' => 'inactive']);

        return back()->with('success', "تم إخفاء {$count} قسم بنجاح.");
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $this->validateBulkIds($request);

        if ($ids === null) {
            return back()->with('error', 'لم يتم تحديد أي أقسام صالحة.');
        }

        // تحقق من وجود منتجات مرتبطة قبل الحذف
        $categoriesWithProducts = Category::whereIn('id', $ids)
            ->whereHas('products')
            ->pluck('name');

        if ($categoriesWithProducts->isNotEmpty()) {
            return back()->with(
                'error',
                'لا يمكن حذف الأقسام التالية لأن لها منتجات مرتبطة: '
                . $categoriesWithProducts->join('، ')
            );
        }

        $categories = Category::whereIn('id', $ids)->get();

        if ($categories->isEmpty()) {
            return back()->with('error', 'لم يتم العثور على الأقسام المحددة.');
        }

        DB::transaction(function () use ($categories) {
            Category::whereIn('id', $categories->pluck('id'))->delete();
        });

        return back()->with('success', "تم حذف {$categories->count()} قسم بنجاح.");
    }

    // ══════════════════════════════════════════════════════════
    //  Private Helpers
    // ══════════════════════════════════════════════════════════

    private function validateBulkIds(Request $request): ?array
    {
        if ($request->has('ids') && is_array($request->ids)) {
            $request->validate([
                'ids'   => ['required', 'array', 'max:' . self::BULK_LIMIT],
                'ids.*' => ['required', 'integer', 'min:1'],
            ]);

            $ids = array_map('intval', $request->ids);
            return ! empty($ids) ? $ids : null;
        }

        if ($request->filled('ids') && is_string($request->ids)) {
            $request->validate([
                'ids' => ['required', 'string', 'regex:/^[\d,\s]+$/'],
            ]);

            $ids = collect(explode(',', $request->ids))
                ->map(fn($id) => trim($id))
                ->filter(fn($id) => is_numeric($id) && (int) $id > 0)
                ->map(fn($id) => (int) $id)
                ->unique()
                ->take(self::BULK_LIMIT)
                ->values()
                ->toArray();

            return ! empty($ids) ? $ids : null;
        }

        return null;
    }

    private function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $original = $slug;
        $count    = 1;

        while (
        Category::where('slug', $slug)
            ->when($ignoreId !== null, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }
}
