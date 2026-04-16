<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\Storage;

class ProductViewController extends Controller
{
    // ══════════════════════════════════════════
    //  FRONT-END (للزبائن)
    // ══════════════════════════════════════════

 public function index(Request $request)
{
    $products = Product::with(['category', 'brand'])
        ->whereHas('category', fn($q) => $q->where('status', 'active'))
        ->whereHas('brand', fn($q) => $q->where('is_active', true))
        ->when($request->category, fn($q) => $q->where('category_id', $request->category))
        ->when($request->brand,    fn($q) => $q->where('brand_id', $request->brand))
        ->when($request->search, fn($q) => $q->where(function ($q2) use ($request) {
    $q2->where('name', 'like', '%' . $request->search . '%')
       ->orWhereHas('brand', fn($b) => $b->where('name', 'like', '%' . $request->search . '%'));
}))
        // ── Stock filter ──
        ->when($request->stock === 'available', fn($q) => $q->where('stock', '>', 10))
        ->when($request->stock === 'low',       fn($q) => $q->where('stock', '>', 0)->where('stock', '<=', 10))
        // ── Sort ──
        ->when($request->sort, fn($q) => match($request->sort) {
            'price_asc'  => $q->orderBy('price'),
            'price_desc' => $q->orderByDesc('price'),
            'name_asc'   => $q->orderBy('name'),
            default      => $q->latest()
        }, fn($q) => $q->latest())
        ->paginate(12)
        ->withQueryString();

    $categories = Category::where('status', 'active')
    ->withCount(['products' => fn($q) => $q
        ->whereHas('brand', fn($q2) => $q2->where('is_active', true)) // لا تحسب منتجات الماركات المخفية
    ])
    ->get();

   $brands = Brand::where('is_active', true)
    ->withCount(['products' => fn($q) => $q
        ->whereHas('category', fn($q2) => $q2->where('status', 'active')) // لا تحسب منتجات الأقسام المخفية
    ])
    ->orderBy('sort_order')
    ->get();

    $activeCategory = $request->category
        ? Category::find($request->category)
        : null;

    $activeBrand = $request->brand
        ? Brand::find($request->brand)
        : null;

    return view('products.index', compact(
        'products', 'categories', 'brands', 'activeCategory', 'activeBrand'
    ));
}

    public function welcome()
    {
        $categories = Category::where('status', 'active')
            ->withCount('products')
            ->get();

        $latestProducts = Product::with(['category', 'brand'])
            ->whereHas('category', fn($q) => $q->where('status', 'active'))
            ->latest()
            ->take(8)
            ->get();

        $discountedProducts = Product::with(['category', 'brand'])
            ->whereHas('category', fn($q) => $q->where('status', 'active'))
            ->where('discount', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('welcome', compact('categories', 'latestProducts', 'discountedProducts'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($id);
        return view('products.show', compact('product'));
    }

    // ══════════════════════════════════════════
    //  ADMIN (للأدمن)
    // ══════════════════════════════════════════

    public function adminIndex(Request $request)
    {
       $products = Product::with(['category', 'brand'])
        ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
        ->when($request->category, fn($q) => $q->where('category_id', $request->category))
        ->latest()
        ->paginate(20)
        ->withQueryString();

    $categories = Category::all();
    $brands     = Brand::all();

    return view('admin.products.index', compact(
        'products', 'categories', 'brands'
    ));
    }
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $brands     = Brand::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

   public function store(ProductRequest $request)
{
    $validated = $request->validated();

    if ($request->hasFile('main_image')) {
        $validated['image_url'] = $request->file('main_image') ->store('products', 'public');
    }

    unset($validated['main_image']);
    Product::create($validated);

    return redirect()->route('admin.products.index')
        ->with('success', 'تم الحفظ بنجاح، يمكنك إضافة منتج آخر الآن');
}

    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $brands     = Brand::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.create', compact('product', 'categories', 'brands'));
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product   = Product::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('main_image')) {
            // حذف الصورة القديمة
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }
            $validated['image_url'] = $request->file('main_image')->store('products', 'public');
        } else {
            unset($validated['image_url']);
        }

        $product->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'تم تعديل المنتج بنجاح');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
}
