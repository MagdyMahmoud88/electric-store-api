<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressesRequest;
use App\Models\Address;
use App\Services\ActivityLogger;
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
    public function store(AddressesRequest $request)
    {
        $validated = $request->validated();

        // إذا اختار المستخدم هذا العنوان كـ "افتراضي"، يجب إلغاء الافتراضي عن الباقي
        if ($request->has('is_default')) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $address = Auth::user()->addresses()->create($validated);
        ActivityLogger::addressAdded(Auth::user(), $address);

        return redirect()->route('profile.index')->with('success', 'تم إضافة العنوان بنجاح');
    }

public function update(AddressesRequest $request, Address $address)
{
    if ($address->user_id !== Auth::id()) abort(403);

    $validated = $request->validated();

    if ($request->has('is_default')) {
        Auth::user()->addresses()->update(['is_default' => false]);
    }

    $address->update($validated);
    return back()->with('success', 'تم تحديث العنوان');
}

public function destroy(Address $address)
{
    if ($address->user_id !== Auth::id()) abort(403);
    $address->delete();
    return back()->with('success', 'تم حذف العنوان');
}

public function setDefault(Address $address)
{
    if ($address->user_id !== Auth::id()) abort(403);
    Auth::user()->addresses()->update(['is_default' => false]);
    $address->update(['is_default' => true]);
    return back()->with('success', 'تم تعيين العنوان الافتراضي');
}

}
