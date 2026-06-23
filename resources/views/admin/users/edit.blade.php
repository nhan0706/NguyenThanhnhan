{{-- Thừa kế layout admin --}}
@extends('admin.layouts.admin')

{{-- Tiêu đề --}}
@section('title', 'Cập nhật Người dùng')

{{-- Nội dung --}}
@section('content')
<h2 class="mb-3">CẬP NHẬT NGƯỜI DÙNG</h2>

@if(session('error'))
    <div class="alert alert-danger mb-3">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('admin.user.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Họ và tên</label>
        <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $user->fullname) }}">
    </div>

    <div class="mb-3">
        <label>Tên đăng nhập</label>
        <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
    </div>

    <div class="mb-3">
        <label>Mật khẩu <small class="text-muted">(để trống nếu không muốn thay đổi)</small></label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3">
        <label>Số điện thoại</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
    </div>

    <div class="mb-3">
        <label>Địa chỉ</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
    </div>

    <div class="mb-3">
        <label>Giới tính</label>
        <select name="gender" class="form-control">
            <option value="1" {{ old('gender', $user->gender) == 1 ? 'selected' : '' }}>Nam</option>
            <option value="0" {{ old('gender', $user->gender) == 0 ? 'selected' : '' }}>Nữ</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Ngày sinh</label>
        <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $user->birthday) }}">
    </div>

    <div class="mb-3">
        <label>Quyền</label>
        <select name="role" class="form-control">
            <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Admin</option>
            <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>Nhân viên</option>
            <option value="3" {{ old('role', $user->role) == 3 ? 'selected' : '' }}>Khách hàng</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
            <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Khóa</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Cập nhật
    </button>

    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
        Quay lại
    </a>
</form>
@endsection
