<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // إضافة تقييم جديد
    public function store(Request $request, int $productId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'من فضلك اختر تقييمك',
            'rating.min'      => 'التقييم يجب أن يكون بين 1 و 5',
            'rating.max'      => 'التقييم يجب أن يكون بين 1 و 5',
            'comment.max'     => 'التعليق لا يتجاوز 1000 حرف',
        ]);

        $user = Auth::user();

        // منع التقييم المكرر
        if ($user->hasReviewed($productId)) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'لقد قيّمت هذا المنتج من قبل'], 422);
            }
            return back()->with('error', 'لقد قيّمت هذا المنتج من قبل');
        }

        $review = Review::create([
            'user_id'    => $user->id,
            'product_id' => $productId,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'is_approved' => $user->isAdmin(),
        ]);
        ActivityLogger::reviewAdded($user, $review);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'شكراً! تقييمك في انتظار المراجعة',
                'review'  => $review->load('user'),
            ], 201);
        }

        return redirect()->route('products.show', $productId)
                     ->with('success', 'شكراً! تقييمك في انتظار المراجعة');
    }

    // تعديل تقييم موجود
    public function update(Request $request, int $productId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->firstOrFail();

        $review->update([
            'rating'      => $request->rating,
            'comment'     => $request->comment,
            'is_approved' => false, // يرجع للمراجعة بعد التعديل
        ]);
        ActivityLogger::reviewUpdated(Auth::user(), $review);

         return redirect()->route('products.show', $productId)
                     ->with('success', 'تم تعديل تقييمك بنجاح');
    }

    // حذف تقييم
    public function destroy(int $productId)
    {
        Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();
        ActivityLogger::reviewDeleted(Auth::user(), $productId);
         return redirect()->route('products.show', $productId)
                     ->with('success', 'تم حذف تقييمك');
    }
}
