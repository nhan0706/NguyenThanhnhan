{{-- Thừa kế layout admin --}}
@extends('admin.layouts.admin')

{{-- Tiêu đề --}}
@section('title', 'Đổi mật khẩu')

{{-- Nội dung --}}
@section('content')
<h2 class="mb-3">Đổi mật khẩu</h2>

<x-admin.alert />

<div class="card shadow-sm">
    <div class="card-body">
        <div class="mb-4">
            <h5>Thông tin người dùng</h5>
            <p class="mb-1"><strong>Họ và tên:</strong> {{ Auth::user()->fullname }}</p>
            <p class="mb-1"><strong>Username:</strong> {{ Auth::user()->username }}</p>
            <p class="mb-0"><strong>Email:</strong> {{ Auth::user()->email }}</p>
        </div>

        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Mật khẩu cũ</label>
                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Nhập mật khẩu cũ">
                @error('current_password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Nhập mật khẩu mới">
                @error('new_password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary ms-2">Quay lại Dashboard</a>
        </form>
    </div>
</div>
@endsection
