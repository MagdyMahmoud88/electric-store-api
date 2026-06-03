<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;

class AdminReturnRequestController extends Controller
{
    // قائمة كل طلبات الإرجاع
    public function index(Request $request)
    {
        $query = ReturnRequest::with(['user', 'product', 'order'])->latest();

        // فلتر بالحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلتر بالبحث (اسم العميل أو رقم الطلب)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                    ->orWhereHas('order', fn($o) => $o->where('id', 'like', "%$search%"));
            });
        }

        $returns = $query->paginate(20)->withQueryString();
        $statusLabels = ReturnRequest::statusLabels();

        return view('admin.returns.index', compact('returns', 'statusLabels'));
    }

    // تفاصيل طلب إرجاع واحد
    public function show(ReturnRequest $return)
    {
        $return->load(['user', 'product', 'order', 'orderItem']);
        return view('admin.returns.show', compact('return'));
    }

    // تحديث حالة الطلب
    public function updateStatus(Request $request, ReturnRequest $return)
    {
        $data = $request->validate([
            'status'     => ['required', 'in:approved,rejected,completed'],
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        $return->update($data);

        $messages = [
            'approved'  => 'تم قبول طلب الإرجاع ✅',
            'rejected'  => 'تم رفض طلب الإرجاع',
            'completed' => 'تم تأكيد استلام المنتج المرتجع ✅',
        ];

        return back()->with('success', $messages[$data['status']]);
    }
}
