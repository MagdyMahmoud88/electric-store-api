<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    } }
