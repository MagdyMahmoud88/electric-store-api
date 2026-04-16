<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brandId = $this->route('brand')?->id;

        return [
            'name' => [
        'required',
        'string',
        'max:100',
        Rule::unique('brands', 'name')
            ->ignore($brandId) // يتجاهل السجل الحالي عند التحديث
            ->whereNull('deleted_at') // يتجاهل الماركات التي تم حذفها ناعماً
    ],

    'slug' => [
        'nullable',
        'string',
        'max:100',
 Rule::unique('brands', 'slug')  ->ignore($brandId)   ->whereNull('deleted_at') ]   ,
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الماركة مطلوب',
            'name.unique'   => 'اسم الماركه موجود بالفعل ف قاعده البيانات',
            'name.max'      => 'اسم الماركة لا يتجاوز 100 حرف',
            'slug.unique'   => 'هذا الـ slug مستخدم بالفعل',
            'logo.image'    => 'يجب أن يكون اللوجو صورة',
            'logo.max'      => 'حجم اللوجو لا يتجاوز 2MB',
        ];
    }
}
