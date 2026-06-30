<?php

namespace App\Http\Requests\Admin;

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
        $id = $this->route('brand');

        return [
            'brandname' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('brands', 'brandname')->ignore($id, 'id'),
            ],
            'slug' => [
                'required',
                'min:3',
                'max:150',
                Rule::unique('brands', 'slug')->ignore($id, 'id'),
                'regex:/^[a-z0-9-]+$/',
            ],
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'brandname.required' => 'Tên thương hiệu không được để trống.',
            'brandname.min' => 'Tên thương hiệu tối thiểu 3 ký tự.',
            'brandname.max' => 'Tên thương hiệu không vượt quá 100 ký tự.',
            'brandname.unique' => 'Tên thương hiệu đã tồn tại.',
            'slug.required' => 'Slug không được để trống.',
            'slug.min' => 'Slug tối thiểu 5 ký tự.',
            'slug.max' => 'Slug không vượt quá 150 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'slug.regex' => 'Slug chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'sort_order.required' => 'Thứ tự sắp xếp không được để trống.',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là số.',
            'sort_order.min' => 'Thứ tự sắp xếp không được âm.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'brandname' => 'Tên thương hiệu',
            'slug' => 'Slug',
            'sort_order' => 'Thứ tự sắp xếp',
            'status' => 'Trạng thái',
        ];
    }
}
