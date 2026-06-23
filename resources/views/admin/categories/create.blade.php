{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thêm Loại Sản phẩm')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">THÊM MỚI LOẠI SẢN PHẨM</h2>

@if(session('error'))
    <div class="alert alert-danger mb-3">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('admin.category.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Tên loại sản phẩm</label>
        <input type="text" name="catename" class="form-control" value="{{ old('catename') }}">
    </div>

    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
    </div>

    <div class="mb-3">
        <label>Thứ tự sắp xếp</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
    </div>

    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
            <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Ẩn</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Lưu
    </button>
    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection