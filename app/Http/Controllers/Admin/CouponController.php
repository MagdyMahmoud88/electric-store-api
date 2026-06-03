<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'                  => 'required|string|max:50|unique:coupons,code',
            'type'                  => 'required|in:percentage,fixed',
            'value'                 => 'required|numeric|min:1',
            'min_order_amount'      => 'nullable|numeric|min:0',
            'max_discount'          => 'nullable|numeric|min:1',
            'usage_limit'           => 'nullable|integer|min:1',
            'usage_limit_per_user'  => 'required|integer|min:1',
            'is_active'             => 'boolean',
            'starts_at'             => 'nullable|date',
            'expires_at'            => 'nullable|date' . ($request->filled('starts_at') ? '|after:starts_at' : ''),
        ], [
            'code.unique'           => 'الكود موجود بالفعل',
            'value.required'        => 'قيمة الخصم مطلوبة',
            'expires_at.after'      => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية',
        ]);

        $data['code']              = strtoupper($data['code']);
        $data['is_active']         = $request->boolean('is_active', true);
        $data['min_order_amount']  = $data['min_order_amount'] ?? 0;

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')
                         ->with('success', 'تم إنشاء الكوبون بنجاح');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.create', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'code'                  => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type'                  => 'required|in:percentage,fixed',
            'value'                 => 'required|numeric|min:1',
            'min_order_amount'      => 'nullable|numeric|min:0',
            'max_discount'          => 'nullable|numeric|min:1',
            'usage_limit'           => 'nullable|integer|min:1',
            'usage_limit_per_user'  => 'required|integer|min:1',
            'is_active'             => 'boolean',
            'starts_at'             => 'nullable|date',
            'expires_at'            => 'nullable|date' . ($request->filled('starts_at') ? '|after_or_equal:starts_at' : ''),
        ]);

        $data['code']             = strtoupper($data['code']);
        $data['is_active']        = $request->boolean('is_active');
        $data['min_order_amount'] = $data['min_order_amount'] ?? 0;

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')
                         ->with('success', 'تم تحديث الكوبون');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'تم حذف الكوبون');
    }

    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        return back()->with('success', $coupon->is_active ? 'تم تفعيل الكوبون' : 'تم إيقاف الكوبون');
    }
}
