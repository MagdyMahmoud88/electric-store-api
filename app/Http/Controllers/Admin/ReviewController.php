<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    // عرض كل التقييمات
    public function index()
    {
        $reviews = Review::with(['user', 'product'])
            ->latest()
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    // موافقة على تقييم
    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'تم اعتماد التقييم');
    }

    // رفض / إخفاء تقييم
    public function reject(Review $review)
    {
        $review->update(['is_approved' => false]);
        return back()->with('success', 'تم إخفاء التقييم');
    }

    // حذف تقييم
    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'تم حذف التقييم');
    }
}
