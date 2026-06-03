<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    // القيم المسموح بيها في الـ color select
    private const COLOR_OPTIONS = [
        'icon-blue',
        'icon-amber',
        'icon-teal',
        'icon-coral',
        'icon-purple',
        'icon-green',
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],

            'slug' => [
                'nullable',
                'string',
                'max:120',
                'regex:/^[a-z0-9\-]*$/',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'icon' => [
                'nullable',
                'string',
                'max:100',
            ],

            // ✅ بيقبل بس القيم الموجودة في الـ select
            'color' => [
                'nullable',
                Rule::in(self::COLOR_OPTIONS),
            ],

            'status' => [
                'nullable',
                Rule::in(['active', 'inactive']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم القسم مطلوب.',
            'name.min'      => 'اسم القسم يجب أن يكون على الأقل حرفين.',
            'name.max'      => 'اسم القسم يجب ألا يتجاوز 100 حرف.',
            'name.unique'   => 'هذا الاسم مستخدم بالفعل، اختر اسماً آخر.',

            'slug.regex'  => 'الـ slug يجب أن يحتوي على أحرف إنجليزية صغيرة وأرقام وشرطة فقط.',
            'slug.unique' => 'هذا الـ slug مستخدم بالفعل.',
            'slug.max'    => 'الـ slug يجب ألا يتجاوز 120 حرفاً.',

            'description.max' => 'الوصف يجب ألا يتجاوز 1000 حرف.',
            'icon.max'        => 'اسم الأيقونة يجب ألا يتجاوز 100 حرف.',
            'color.in'        => 'اللون المختار غير صالح.',
            'status.in'       => 'الحالة يجب أن تكون active أو inactive فقط.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('name')) {
            $this->merge(['name' => trim($this->name)]);
        }

        if ($this->filled('slug')) {
            $this->merge(['slug' => trim(strtolower($this->slug))]);
        }
    }
}
