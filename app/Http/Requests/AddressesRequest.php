<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddressesRequest extends FormRequest
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
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'phone'           => 'required|string|max:20',
            'city'            => 'required|string',
            'area'            => 'nullable|string',
            'street_address'  => 'required|string',
            'building_number' => 'nullable|string',
            'governorate'     => 'required|string',
            'is_default'      => 'boolean',
        ];


    }
    public function messages(): array{
        return [
            // الاسم الأول
            'first_name.required'      => 'يرجى إدخال الاسم الأول.',
            'first_name.string'        => 'الاسم الأول يجب أن يكون نصاً صالحاً.',
            'first_name.max'           => 'الاسم الأول يجب ألا يتجاوز 255 حرفاً.',

            // الاسم الأخير
            'last_name.required'       => 'يرجى إدخال اسم العائلة (الاسم الأخير).',
            'last_name.string'         => 'اسم العائلة يجب أن يكون نصاً صالحاً.',
            'last_name.max'            => 'اسم العائلة يجب ألا يتجاوز 255 حرفاً.',

            // رقم الهاتف
            'phone.required'           => 'رقم الهاتف مطلوب للتواصل أثناء التوصيل.',
            'phone.string'             => 'يرجى إدخال رقم هاتف صحيح.',
            'phone.max'                => 'رقم الهاتف طويل جداً، يرجى التحقق منه.',

            // المدينة
            'city.required'            => 'يرجى اختيار أو كتابة المدينة.',
            'city.string'              => 'اسم المدينة غير صالح.',

            // المنطقة / الحي
            'area.string'              => 'اسم المنطقة يجب أن يكون نصاً صالحاً.',

            // العنوان بالتفصيل (الشارع)
            'street_address.required'  => 'يرجى كتابة عنوان الشارع بالتفصيل لسهولة التوصيل.',
            'street_address.string'    => 'العنوان التفصيلي غير صالح.',

            // رقم المبنى
            'building_number.string'   => 'رقم المبنى أو الطابق يجب أن يكون نصاً صالحاً.',

            // المحافظة
            'governorate.string'       => 'اسم المحافظة يجب أن يكون نصاً صالحاً.',
            'governorate.required' => 'يرجى اختيار أو كتابة المحافظة.',

            // العنوان الافتراضي
            'is_default.boolean'       => 'حقل تحديد العنوان الافتراضي يجب أن يكون صحيحاً أو خاطئاً.',

            ];
    }
}
