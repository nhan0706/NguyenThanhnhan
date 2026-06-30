{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thêm Bài viết')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">THÊM MỚI BÀI VIẾT</h2>

<x-admin.alert />

<form action="{{ route('admin.post.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Tiêu đề</label>
        <input type="text"
               name="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title') }}">
        @error('title')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Slug</label>
        <input type="text"
               name="slug"
               class="form-control @error('slug') is-invalid @enderror"
               value="{{ old('slug') }}">
        @error('slug')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Nội dung</label>
        <textarea name="content"
                  class="form-control @error('content') is-invalid @enderror"
                  rows="6">{{ old('content') }}</textarea>
        @error('content')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Tác giả</label>
        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
            <option value="">-- Chọn tác giả --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->fullname }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control @error('status') is-invalid @enderror">
            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
            <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Ẩn</option>
        </select>
        @error('status')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Lưu
    </button>
    <a href="{{ route('admin.post.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
