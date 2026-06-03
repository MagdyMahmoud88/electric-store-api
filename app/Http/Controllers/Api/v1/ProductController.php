<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        //  $products = Product::with('category')->latest()->paginate(4);
        $query = Product::with(['category', 'brand', 'approvedReviews']);



        // 1. ميزة البحث بالاسم (New ✨)
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        }
 //  2. التصفية حسب الفئة (category_id)
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 3. الترتيب حسب السعر (أرخص أولاً أو أغلى أولاً)
        if ($request->sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        }
        // الافتراضي: الأحدث أولاً
        // $query->latest();
        // 4. جلب البيانات النهائية
        $products = $query->paginate(10);
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        // التأكد من وجود ملف صورة في الطلب
        if ($request->hasFile('image_url')) {
            // تخزين الصورة في مجلد storage/app/public/products
            $path = $request->file('image_url')->store('products', 'public');

            // حفظ المسار الجديد في قاعدة البيانات
            $validated['image_url'] = $path;
        }
        $product = Product::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'تم إنشاء المنتج بنجاح',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product->load(['category', 'brand', 'approvedReviews']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        /*
        $product = Product::findOrFail($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }
*/

        $product->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث المنتج بنجاح',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        $product->delete();
        return response()->json([
            'status' => true,
            'message' => 'تم حذف المنتج بنجاح',
        ]);
    }
}
