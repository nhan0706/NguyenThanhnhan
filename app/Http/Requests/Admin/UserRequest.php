<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user');

        return [
            'fullname' => 'required|min:3|max:100',
            'username' => [
                'required',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users', 'username')->ignore($id, 'id'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id, 'id'),
            ],
            'password' => $this->isMethod('post')
                ? ['required', 'min:6', 'confirmed']
                : ['nullable', 'min:6', 'confirmed'],
            'phone' => [
                'nullable',
                'regex:/^[0-9\-+()]{10,}$/',
                Rule::unique('users', 'phone')->ignore($id, 'id'),
            ],
            'address' => 'nullable|max:255',
            'gender' => 'required|in:0,1',
            'birthday' => 'nullable|date|before:today',
            'role' => 'required|in:1,2,3',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Họ và tên không được để trống.',
            'fullname.min' => 'Họ và tên tối thiểu 3 ký tự.',
            'fullname.max' => 'Họ và tên không vượt quá 100 ký tự.',
            'username.required' => 'Tên đăng nhập không được để trống.',
            'username.min' => 'Tên đăng nhập tối thiểu 3 ký tự.',
            'username.max' => 'Tên đăng nhập không vượt quá 50 ký tự.',
            'username.unique' => 'Tên đăng nhập đã tồn tại.',
            'username.regex' => 'Tên đăng nhập chỉ được chứa chữ, số và dấu gạch dưới (_).',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'address.max' => 'Địa chỉ không vượt quá 255 ký tự.',
            'gender.required' => 'Giới tính không được để trống.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'birthday.date' => 'Ngày sinh không hợp lệ.',
            'birthday.before' => 'Ngày sinh phải trước hôm nay.',
            'role.required' => 'Quyền không được để trống.',
            'role.in' => 'Quyền không hợp lệ.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'fullname' => 'Họ và tên',
            'username' => 'Tên đăng nhập',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'gender' => 'Giới tính',
            'birthday' => 'Ngày sinh',
            'role' => 'Quyền',
            'status' => 'Trạng thái',
        ];
    }
}
