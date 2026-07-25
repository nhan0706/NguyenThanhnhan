<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('post');

        return [
            'title' => [
                'required',
                'min:5',
                'max:200',
                Rule::unique('posts', 'title')->ignore($id, 'id'),
            ],
            'slug' => [
                'required',
                'min:5',
                'max:255',
                'regex:/^[a-z0-9\-]+$/',
                Rule::unique('posts', 'slug')->ignore($id, 'id'),
            ],
            'content' => 'required|min:10',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề không được để trống.',
            'title.min' => 'Tiêu đề tối thiểu 5 ký tự.',
            'title.max' => 'Tiêu đề không vượt quá 200 ký tự.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
            'slug.required' => 'Slug không được để trống.',
            'slug.min' => 'Slug tối thiểu 5 ký tự.',
            'slug.max' => 'Slug không vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'slug.regex' => 'Slug chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'content.required' => 'Nội dung không được để trống.',
            'content.min' => 'Nội dung tối thiểu 10 ký tự.',
            'user_id.required' => 'Tác giả không được để trống.',
            'user_id.exists' => 'Tác giả không tồn tại.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề',
            'slug' => 'Slug',
            'content' => 'Nội dung',
            'user_id' => 'Tác giả',
            'status' => 'Trạng thái',
        ];
    }
}
