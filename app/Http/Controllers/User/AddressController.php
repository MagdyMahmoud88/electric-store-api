<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // عرض جميع عناوين المستخدم
    public function index()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('user.profile.addresses.index', compact('addresses'));
    }

    // حفظ عنوان جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'city'           => 'required|string',
            'area'           => 'required|string',
            'street_address' => 'required|string',
            'building_number'=> 'nullable|string',
            'is_default'     => 'boolean',
        ]);

        // إذا اختار المستخدم هذا العنوان كـ "افتراضي"، يجب إلغاء الافتراضي عن الباقي
        if ($request->has('is_default')) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        Auth::user()->addresses()->create($validated);

        return redirect()->route('profile.index')->with('success', 'تم إضافة العنوان بنجاح');
    }
}
