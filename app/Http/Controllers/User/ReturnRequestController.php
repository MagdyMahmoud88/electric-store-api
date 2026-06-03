<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReturnRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReturnRequestController extends Controller
{
    // عرض قائمة طلبات الإرجاع للمستخدم
    public function index()
    {
        $returns = ReturnRequest::where('user_id', auth()->id())
            ->with(['product', 'order'])
            ->latest()
            ->paginate(10);

        return view('user.returns.index', compact('returns'));
    }

    // فورم طلب الإرجاع
    public function create(Order $order, OrderItem $item)
    {
        // تأكيد إن الطلب بتاع المستخدم ده
        abort_if($order->user_id !== auth()->id(), 403);

        // تأكيد إن الـ item ينتمي للـ order
        abort_if($item->order_id !== $order->id, 403);

        // تأكيد إن الطلب delivered
        abort_if($order->status !== 'delivered', 403, 'لا يمكن طلب إرجاع إلا للطلبات المسلّمة');

        // تأكيد مفيش طلب إرجاع موجود على نفس الـ item
        $exists = ReturnRequest::where('order_item_id', $item->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        abort_if($exists, 403, 'يوجد طلب إرجاع مسبق لهذا المنتج');

        $reasons = ReturnRequest::reasonLabels();

        return view('user.returns.create', compact('order', 'item', 'reasons'));
    }

    // حفظ طلب الإرجاع
    public function store(Request $request, Order $order, OrderItem $item)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if($item->order_id !== $order->id, 403);
        abort_if($order->status !== 'delivered', 403);

        $exists = ReturnRequest::where('order_item_id', $item->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
        abort_if($exists, 403);

        $data = $request->validate([
            'reason'      => ['required', 'in:defective,wrong_item,not_as_described,changed_mind,other'],
            'description' => ['nullable', 'string', 'max:1000'],
            'images'      => ['nullable', 'array', 'max:4'],
            'images.*'    => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'reason.required' => 'من فضلك اختار سبب الإرجاع',
            'images.*.image'  => 'الملفات لازم تكون صور فقط',
            'images.*.max'    => 'الصورة أكبر من 2MB',
        ]);

        // رفع الصور
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $uploadedImages[] = $img->store('returns', 'public');
            }
        }

        ReturnRequest::create([
            'user_id'       => auth()->id(),
            'order_id'      => $order->id,
            'order_item_id' => $item->id,
            'product_id'    => $item->product_id,
            'reason'        => $data['reason'],
            'description'   => $data['description'] ?? null,
            'images'        => $uploadedImages ?: null,
            'status'        => 'pending',
        ]);
        ActivityLogger::orderReturned(auth()->user(), $order);
        return redirect()->route('returns.index')
            ->with('success', 'تم إرسال طلب الإرجاع، هنتواصل معاك قريباً ✅');
    }

    // عرض تفاصيل طلب إرجاع واحد
    public function show(ReturnRequest $return)
    {
        abort_if($return->user_id !== auth()->id(), 403);
        $return->load(['product', 'order', 'orderItem']);
        $order = $return->order;
        $item  = $return->orderItem;

        return view('user.returns.show', compact('return','order','item'));
    }
}
