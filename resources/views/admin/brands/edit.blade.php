{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Cập nhật Thương hiệu')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">CẬP NHẬT THƯƠNG HIỆU</h2>

<x-admin.alert />

<form action="{{ route('admin.brand.update', $brand->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Tên thương hiệu</label>
        <input type="text"
               name="brandname"
               class="form-control @error('brandname') is-invalid @enderror"
               value="{{ old('brandname', $brand->brandname) }}">
        @error('brandname')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Slug</label>
        <input type="text"
               name="slug"
               class="form-control @error('slug') is-invalid @enderror"
               value="{{ old('slug', $brand->slug) }}">
        @error('slug')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Thứ tự sắp xếp</label>
        <input type="number"
               name="sort_order"
               class="form-control @error('sort_order') is-invalid @enderror"
               value="{{ old('sort_order', $brand->sort_order) }}">
        @error('sort_order')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description"
                  class="form-control @error('description') is-invalid @enderror"
                  rows="4">{{ old('description', $brand->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control @error('status') is-invalid @enderror">
            <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>
                Hiển thị
            </option>
            <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>
                Ẩn
            </option>
        </select>
        @error('status')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Cập nhật
    </button>
    <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
