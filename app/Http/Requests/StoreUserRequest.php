<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\s]+$/u'
            ],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'     => 'حقل الاسم الكامل مطلوب ولا يمكن تركه فارغاً.',
            'name.string'       => 'يجب أن يكون الاسم عبارة عن نص صحيح.',
            'name.max'          => 'يجب ألا يتجاوز الاسم 255 حرفاً.',
            'name.regex' => 'يجب أن يحتوي الاسم على حروف فقط (عربية أو إنجليزية) بدون أرقام أو رموز خاصة.',

            'email.required'    => 'البريد الإلكتروني مطلوب للدخول وحماية حسابك.',
            'email.email'       => 'يرجى إدخال عنوان بريد إلكتروني بشكل صحيح (مثال: name@example.com).',
            'email.max'         => 'يجب ألا يتجاوز البريد الإلكتروني 255 حرفاً.',
            'email.unique'      => 'هذا البريد الإلكتروني مسجل لدينا بالفعل، يرجى تسجيل الدخول أو استخدام بريد آخر.',

            'password.required' => 'كلمة المرور مطلوبة لتأمين الحساب.',
            'password.min'      => 'لحمايتك، يجب ألا تقل كلمة المرور عن 8 أحرف أو أرقام.',
            'password.confirmed'=> 'تأكيد كلمة المرور غير متطابق، يرجى كتابتها بشكل متماثل في الحقلين.',
        ];
    }
}
