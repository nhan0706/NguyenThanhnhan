<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('product');
        $isUpdate = !empty($id);
        $imgRule = $isUpdate
            ? ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:200']
            : ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:200'];

        return [
            'productname' => [
                'required',
                'string',
                'min:5',
                'max:150',
                Rule::unique('products', 'productname')->ignore($id, 'id'),
            ],
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:200',
                'regex:/^[a-z0-9_-]+$/',
                Rule::unique('products', 'slug')->ignore($id, 'id'),
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999.99',
            ],
            'pricediscount' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price',
            ],
            'status' => 'required|in:0,1',
            'cateid' => 'required|exists:categories,cateid',
            'brandid' => 'nullable|exists:brands,id',
            'description' => ['nullable', 'regex:/^[^@!$\^]*$/'],
            'img' => $imgRule,
            'imgs' => [
                'nullable',
                'array',
            ],
            'imgs.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:200',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'numeric' => ':attribute phải là số.',
            'unique' => ':attribute đã tồn tại.',
            'regex' => ':attribute không hợp lệ.',
            'price.max' => ':attribute phải nhỏ hơn 10.000.000.',
            'lte' => ':attribute không được lớn hơn giá gốc.',
            'in' => ':attribute không hợp lệ.',
            'exists' => ':attribute không tồn tại.',
            'img.image' => ':attribute phải là hình ảnh.',
            'img.mimes' => ':attribute chỉ chấp nhận định dạng: jpg, jpeg, png, webp.',
            'img.max' => ':attribute không được vượt quá 200 KB.',
            'imgs.array' => ':attribute không hợp lệ.',
            'imgs.*.image' => 'Mỗi ảnh phải là tệp hình ảnh hợp lệ.',
            'imgs.*.mimes' => 'Mỗi ảnh chỉ chấp nhận định dạng: jpg, jpeg, png, webp.',
            'imgs.*.max' => 'Mỗi ảnh không được vượt quá 200 KB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Slug',
            'price' => 'Giá',
            'pricediscount' => 'Giá khuyến mãi',
            'status' => 'Trạng thái',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'description' => 'Mô tả',
            'img' => 'Ảnh chính',
            'imgs' => 'Ảnh phụ',
        ];
    }
}
