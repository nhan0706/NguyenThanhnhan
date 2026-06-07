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
        <input type="text" name="catename" class="form-control" value="{{ $category->catename }}">
    </div>
    
    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ $category->slug }}">
    </div>
    
    <button type="submit" class="btn btn-primary">
        Cập nhật
    </button>
    <a href="{{ route('category.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
