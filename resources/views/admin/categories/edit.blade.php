{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Cập nhật Loại Sản phẩm')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">CẬP NHẬT LOẠI SẢN PHẨM</h2>

<form action="{{ route('category.update', $category->cateid) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label>Tên loại sản phẩm</label>
        <input type="text"
               name="catename"
               class="form-control"
               value="{{ $category->catename }}">
    </div>
    
    <div class="mb-3">
        <label>Slug</label>
        <input type="text"
               name="slug"
               class="form-control"
               value="{{ $category->slug }}">
    </div>

    <div class="mb-3">
        <label>Thứ tự sắp xếp</label>
        <input type="number"
               name="sort_order"
               class="form-control"
               value="{{ $category->sort_order }}">
    </div>

    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description"
                  class="form-control"
                  rows="4">{{ $category->description }}</textarea>
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>
                Hiển thị
            </option>
            <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>
                Ẩn
            </option>
        </select>
    </div>
    
    
    <button type="submit" class="btn btn-primary">
        Cập nhật
    </button>
    <a href="{{ route('category.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
