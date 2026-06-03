<?php
namespace App\Http\Controllers\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:100',

        ]);
        $user->update($request->only('name'));
        ActivityLogger::profileUpdated($user, $request->only('name'));

        return back()->with('success', 'تم تحديث البيانات بنجاح');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        ActivityLogger::passwordChanged($user);
        return back()->with('success_password', 'تم تغيير كلمة المرور بنجاح');
    }

    public function reviews()
{
    // جلب تقييمات المستخدم الحالي مع بيانات المنتج المرتبط بالتقييم
    $reviews = Auth::user()->reviews()->with('product')->latest()->paginate(10);

    return view('user.profile.reviews', compact('reviews'));
}
}
