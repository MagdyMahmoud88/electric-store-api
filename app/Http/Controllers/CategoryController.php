<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
     public function index(Request $request)
    {

        $query = Category::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['active', 'inactive'])) {
            $query->where('status', $request->status);
        }

     //   $categories = $query->latest()->get();
        $categories = Category::withCount('products')->get();

        $stats = [
            'total'    => Category::count(),
            'active'   => Category::active()->count(),
            'inactive' => Category::inactive()->count(),
            'products' => Product::count(),
        ];

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
            'icon'        => 'nullable|string|max:10',
            'color'       => 'required|in:icon-blue,icon-amber,icon-teal,icon-coral,icon-purple,icon-green',
            'status'      => 'required|in:active,inactive',
        ], [
            'name.required' => 'اسم الـ category مطلوب',
            'name.unique'   => 'اسم الـ category موجود بالفعل',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['icon'] = $validated['icon'] ?? '📦';

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم إضافة الـ category بنجاح');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => 'nullable|string|max:1000',
            'icon'        => 'nullable|string|max:10',
            'color'       => 'required|in:icon-blue,icon-amber,icon-teal,icon-coral,icon-purple,icon-green',
            'status'      => 'required|in:active,inactive',
        ], [
            'name.required' => 'اسم الـ category مطلوب',
            'name.unique'   => 'اسم الـ category موجود بالفعل',
        ]);

        $validated['icon'] = $validated['icon'] ?? '📦';

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم تعديل الـ category بنجاح');
    }

    public function toggleStatus(Category $category)
{
    // تبديل الحالة برمجياً: إذا كانت active تصبح inactive والعكس
    $category->status = ($category->status === 'active') ? 'inactive' : 'active';
    $category->save();

    return response()->json([
        'success' => true,
        'new_status' => $category->status,
        'message' => 'تم تحديث الحالة بنجاح'
    ]);
}

    public function destroy(Category $category)
    {


    // 1. التحقق من وجود منتجات مرتبطة (المنع البرمجي قبل قاعدة البيانات)
    // نستخدم count() مباشرة على العلاقة لضمان الدقة والأداء
    if ($category->products()->exists()) {
        return redirect()->back()->with([
            'error' => 'لا يمكن حذف هذا القسم! يوجد ' . $category->products()->count() . ' منتج مرتبطة به حالياً.',
            'info' => 'يرجى نقل المنتجات إلى قسم آخر أو حذفها أولاً لتتمكن من حذف القسم.'
        ]);
    }

    try {
        // 2. محاولة الحذف الفعلي
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم حذف القسم بنجاح من قاعدة البيانات.');

    } catch (\Exception $e) {
        // 3. التعامل مع أي خطأ تقني غير متوقع من قاعدة البيانات
        return redirect()->back()
            ->with('error', 'حدث خطأ أثناء محاولة الحذف: ' . $e->getMessage());
    }
}
}
