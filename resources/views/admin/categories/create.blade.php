{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thêm Loại Sản phẩm')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">THÊM MỚI LOẠI SẢN PHẨM</h2>

<form action="{{ route('category.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Tên loại sản phẩm</label>
        <input type="text" name="catename" class="form-control">
    </div>
    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">
        Lưu
    </button>
</form>
@endsection
