<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
    'name'        => 'required|string|max:255|unique:products,name',
    'description' => 'nullable|string',
    'category_id' => 'required|exists:categories,id',
    'brand_id'    => 'nullable|exists:brands,id',
    'main_image'  => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
    'price'       => 'required|numeric|min:0',
    'stock'       => 'required|integer|min:0',
    'discount_percentage'    => 'nullable|numeric|min:0|max:100',
];}

        public function messages(): array
        {
            return [
                'name.required' => 'اسم المنتج مطلوب',
                'name.unique' => '  الاسم المنتج يجب أن يكون فريدًا المنتج موجود بالفعل',
                'name.string' => 'اسم المنتج يجب أن يكون نصًا',
                'name.max' => 'اسم المنتج لا يجب أن يتجاوز 255 حرفًا',
                'description.string' => 'وصف المنتج يجب أن يكون نصًا',
                'category_id.required' => 'معرف الفئة مطلوب',
                'category_id.exists' => 'معرف الفئة غير صالح',
                'image_url.url' => 'رابط الصورة غير صالح',
                'price.required' => 'السعر مطلوب',
                'price.numeric' => 'السعر يجب أن يكون رقمًا',
                'price.min' => 'السعر لا يجب أن يكون أقل من 0',
                'stock.required' => 'الكمية في المخزون مطلوبة',
                'stock.integer' => 'الكمية في المخزون يجب أن تكون عددًا صحيحًا',
                'stock.min' => 'الكمية في المخزون لا يجب أن تكون أقل من 0',
                'brand_id.exists'             => 'الماركة المختارة غير موجودة',
                'discount_percentage.numeric' => 'نسبة الخصم يجب أن تكون رقمًا',
                'discount_percentage.max'     => 'نسبة الخصم لا تتجاوز 100%',
            ];
        }
}
