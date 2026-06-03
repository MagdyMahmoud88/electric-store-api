<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckoutRequest extends FormRequest
{
    /**
     * المستخدم لازم يكون logged in
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * قواعد التحقق
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[\p{Arabic}a-zA-Z\s]+$/u', // عربي أو إنجليزي فقط
            ],
            'last_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[\p{Arabic}a-zA-Z\s]+$/u',
            ],
            'email' => [
                'required',
                'email:rfc,dns', // تحقق من صحة الـ email + DNS
                'max:255',
            ],
            'phone' => [
                'required',
                'regex:/^(\+20|0)?1[0125][0-9]{8}$/', // أرقام مصرية فقط
            ],
            'address' => [
                'required',
                'string',
                'min:10',
                'max:255',
            ],
            'city' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[\p{Arabic}a-zA-Z\s]+$/u',
            ],
            'governorate' => [
                'required',
                'string',
                'in:' . implode(',', $this->validGovernorates()),
            ],
            'payment_method' => [
                'required',
                'string',
                'in:card,vodafone,instapay',
            ],
        ];
    }

    /**
     * رسائل الخطأ بالعربي
     */
    public function messages(): array
    {
        return [
            'first_name.required'    => 'الاسم الأول مطلوب',
            'first_name.min'         => 'الاسم الأول لا يقل عن حرفين',
            'first_name.max'         => 'الاسم الأول لا يتجاوز 50 حرف',
            'first_name.regex'       => 'الاسم الأول يجب أن يحتوي على حروف فقط',


            'last_name.required'     => 'الاسم الأخير مطلوب',
            'last_name.min'          => 'الاسم الأخير لا يقل عن حرفين',
            'last_name.max'          => 'الاسم الأخير لا يتجاوز 50 حرف',
            'last_name.regex'        => 'الاسم الأخير يجب أن يحتوي على حروف فقط',

            'email.required'         => 'البريد الإلكتروني مطلوب',
            'email.email'            => 'البريد الإلكتروني غير صحيح',
            'email.max'              => 'البريد الإلكتروني طويل جداً',

            'phone.required'         => 'رقم الهاتف مطلوب',
            'phone.regex'            => 'رقم الهاتف يجب أن يكون رقم مصري صحيح (مثال: 01012345678)',

            'address.required'       => 'العنوان مطلوب',
            'address.min'            => 'العنوان يجب أن يكون 10 أحرف على الأقل',
            'address.max'            => 'العنوان طويل جداً',

            'city.required'          => 'المدينة مطلوبة',
            'city.regex'             => 'اسم المدينة يجب أن يحتوي على حروف فقط',

            'governorate.required'   => 'المحافظة مطلوبة',
            'governorate.in'         => 'المحافظة المختارة غير صحيحة',

            'payment_method.required'=> 'طريقة الدفع مطلوبة',
            'payment_method.in'      => 'طريقة الدفع غير مدعومة',
        ];
    }

    /**
     * تنظيف البيانات قبل التحقق (sanitize)
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'first_name'     => strip_tags(trim($this->first_name ?? '')),
            'last_name'      => strip_tags(trim($this->last_name ?? '')),
            'email'          => strtolower(trim($this->email ?? '')),
            'phone'          => preg_replace('/\s+/', '', $this->phone ?? ''),
            'address'        => strip_tags(trim($this->address ?? '')),
            'city'           => strip_tags(trim($this->city ?? '')),
            'governorate'    => trim($this->governorate ?? ''),
            'payment_method' => trim($this->payment_method ?? ''),
        ]);
    }

    /**
     * قائمة المحافظات المصرية الصحيحة
     */
    private function validGovernorates(): array
    {
        return [
            'القاهرة', 'الجيزة', 'الإسكندرية', 'الغربية', 'الشرقية',
            'المنوفية', 'الدقهلية', 'كفر الشيخ', 'دمياط', 'البحيرة',
            'الإسماعيلية', 'بورسعيد', 'السويس', 'شمال سيناء', 'جنوب سيناء',
            'الفيوم', 'بني سويف', 'المنيا', 'أسيوط', 'سوهاج',
            'قنا', 'الأقصر', 'أسوان', 'مطروح', 'الوادي الجديد', 'البحر الأحمر',
        ];
    }
}
