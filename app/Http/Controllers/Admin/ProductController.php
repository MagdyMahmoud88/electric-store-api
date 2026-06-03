<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    // ══════════════════════════════════════════════════════════
    //  index
    // ══════════════════════════════════════════════════════════

    public function index(Request $request): View
    {
        $products = Product::with(['category', 'brand'])
            ->withAvg('approvedReviews', 'rating')
            ->withCount('approvedReviews')
            ->when($request->filled('category'), fn($q) => $q->where('category_id', $request->category))
            ->when($request->filled('brand'),    fn($q) => $q->where('brand_id',    $request->brand))
            ->when($request->filled('search'),   fn($q) => $q->where(function ($q2) use ($request) {
                $q2->where('name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('brand', fn($b) => $b->where('name', 'like', '%' . $request->search . '%'));
            }))
            // ── Stock filter ──────────────────────────────────
            ->when($request->stock === 'available', fn($q) => $q->where('stock', '>', 10))
            ->when($request->stock === 'low',       fn($q) => $q->whereBetween('stock', [1, 10]))
            ->when($request->stock === 'out',       fn($q) => $q->where('stock', 0))
            // ── Active filter ─────────────────────────────────
            ->when($request->status === 'active',   fn($q) => $q->where('is_active', true))
            ->when($request->status === 'inactive', fn($q) => $q->where('is_active', false))
            // ── Sort ──────────────────────────────────────────
            ->when($request->filled('sort'), fn($q) => match($request->sort) {
                'price_asc'  => $q->orderBy('price'),
                'price_desc' => $q->orderByDesc('price'),
                'name_asc'   => $q->orderBy('name'),
                'stock_asc'  => $q->orderBy('stock'),
                default      => $q->latest(),
            }, fn($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('status', 'active')->withCount('products')->get();
        $brands     = Brand::where('is_active', true)->withCount('products')->orderBy('sort_order')->get();

        $stats = [
            'total'      => Product::count(),
            'active'     => Product::where('is_active', true)->count(),
            'inactive'   => Product::where('is_active', false)->count(),
            'out_stock'  => Product::where('stock', 0)->count(),
            'low_stock'  => Product::whereBetween('stock', [1, 10])->count(),
        ];

        $activeCategory = $request->filled('category') ? Category::find($request->category) : null;
        $activeBrand    = $request->filled('brand')    ? Brand::find($request->brand)       : null;

        // للتوافق مع الـ view القديم
        $outOfStockCount = $stats['out_stock'];
        $totalProducts   = $stats['total'];

        return view('admin.products.index', compact(
            'products', 'categories', 'brands',
            'activeCategory', 'activeBrand',
            'outOfStockCount', 'totalProducts', 'stats'
        ));
    }

    // ══════════════════════════════════════════════════════════
    //  create
    // ══════════════════════════════════════════════════════════

    public function create(): View
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $brands     = Brand::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    // ══════════════════════════════════════════════════════════
    //  store
    // ══════════════════════════════════════════════════════════

    public function store(ProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('main_image')) {
            $validated['image_url'] = $request->file('main_image')
                ->store('products', 'public');
        }

        unset($validated['main_image']);

        // ✅ is_active افتراضي true لو مجاش من الفورم
        $validated['is_active'] = $validated['is_active'] ?? true;

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    // ══════════════════════════════════════════════════════════
    //  edit
    // ══════════════════════════════════════════════════════════

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $brands     = Brand::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    // ══════════════════════════════════════════════════════════
    //  update
    // ══════════════════════════════════════════════════════════

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('main_image')) {
            // ✅ احذف الصورة القديمة لو موجودة
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }
            $validated['image_url'] = $request->file('main_image')
                ->store('products', 'public');
        } else {
            unset($validated['image_url']);
        }

        // ✅ is_active checkbox — لو مش موجود في الـ request معناه false
        $validated['is_active'] = $request->boolean('is_active');

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تعديل المنتج بنجاح');
    }

    // ══════════════════════════════════════════════════════════
    //  destroy
    // ══════════════════════════════════════════════════════════

    public function destroy(Product $product): RedirectResponse
    {
        // ✅ احذف الصورة من الـ storage
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }

    // ══════════════════════════════════════════════════════════
    //  toggleStatus — تفعيل/إيقاف المنتج
    // ══════════════════════════════════════════════════════════

    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        $label = $product->is_active ? 'تفعيل' : 'إيقاف';

        return back()->with('success', "تم {$label} المنتج بنجاح");
    }
}
