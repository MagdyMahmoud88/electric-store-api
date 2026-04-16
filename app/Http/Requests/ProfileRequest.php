<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class ProfileRequest extends FormRequest
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
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'الاسم مطلوب',
            'name.string'    => 'الاسم يجب أن يكون نصًا',
            'name.max'       => 'الاسم لا يجب أن يتجاوز 100 حرف',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email'    => 'البريد الإلكتروني غير صالح',
            'email.unique'   => 'البريد الإلكتروني مستخدم بالفعل',
        ];
    }
}
