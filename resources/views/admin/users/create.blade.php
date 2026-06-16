{{-- Thừa kế layout admin --}}
@extends('admin.layouts.admin')

{{-- Tiêu đề --}}
@section('title', 'Thêm Người dùng')

{{-- Nội dung --}}
@section('content')
<h2 class="mb-3">THÊM MỚI NGƯỜI DÙNG</h2>

<form action="{{ route('user.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Họ và tên</label>
        <input type="text" name="fullname" class="form-control">
    </div>

    <div class="mb-3">
        <label>Tên đăng nhập</label>
        <input type="text" name="username" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Mật khẩu</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3">
        <label>Số điện thoại</label>
        <input type="text" name="phone" class="form-control">
    </div>

    <div class="mb-3">
        <label>Địa chỉ</label>
        <input type="text" name="address" class="form-control">
    </div>

    <div class="mb-3">
        <label>Giới tính</label>
        <select name="gender" class="form-control">
            <option value="1">Nam</option>
            <option value="0">Nữ</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Ngày sinh</label>
        <input type="date" name="birthday" class="form-control">
    </div>

    <div class="mb-3">
        <label>Quyền</label>
        <select name="role" class="form-control">
            <option value="1">Admin</option>
            <option value="2">Nhân viên</option>
            <option value="3">Khách hàng</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1">Hoạt động</option>
            <option value="0">Khóa</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Lưu
    </button>

    <a href="{{ route('user.index') }}" class="btn btn-secondary">
        Quay lại
    </a>
</form>
@endsection
