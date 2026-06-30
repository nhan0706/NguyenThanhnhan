{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thêm Thương hiệu')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">THÊM MỚI THƯƠNG HIỆU</h2>

<x-admin.alert />

<form action="{{ route('admin.brand.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Tên thương hiệu</label>
        <input type="text"
               name="brandname"
               class="form-control @error('brandname') is-invalid @enderror"
               value="{{ old('brandname') }}">
        @error('brandname')
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
        <label>Thứ tự sắp xếp</label>
        <input type="number"
               name="sort_order"
               class="form-control @error('sort_order') is-invalid @enderror"
               value="{{ old('sort_order', 0) }}">
        @error('sort_order')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description"
                  class="form-control"
                  rows="4">{{ old('description') }}</textarea>
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

    <a href="{{ route('admin.brand.index') }}"
       class="btn btn-secondary">
        Quay lại
    </a>
</form>
@endsection
