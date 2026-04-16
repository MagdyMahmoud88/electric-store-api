<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(LoginRequest $request)
    {

    // نمرر الإيميل والباسورد فقط للمطابقة
    $credentials = $request->only('email', 'password');

    // نتحقق من وجود حقل تذكرني
    $remember = $request->boolean('remember');// الحصول على قيمة "تذكرني" كقيمة بوليانية
    // 2. محاولة تسجيل الدخول مع دعم خاصية "تذكرني" إذا وجدت
    if (Auth::attempt($credentials, $remember)) {

        // 3. تجديد الجلسة (خطوة أمنية ممتازة أنت فعلتها بالفعل)
        $request->session()->regenerate();

        // 4. التوجيه إلى الصفحة التي كان يحاول المستخدم دخولها (Intended)
        // أو إلى المنتجات كخيار افتراضي
        return redirect()->intended(route('products.index'));
    }

    // 5. في حال الفشل: العودة مع رسالة خطأ مرتبطة بحقل الإيميل
    return back()->withErrors([
        'email' => 'بيانات الاعتماد المقدمة غير متطابقة مع سجلاتنا.',
    ])->onlyInput('email');

    }

    public function destroy(Request $request)
    {
       Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();


     return redirect()->route('register.index');
    }
}
