{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thêm Thương hiệu')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">THÊM MỚI THƯƠNG HIỆU</h2>

<form action="{{ route('brand.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Tên thương hiệu</label>
        <input type="text"
               name="brandname"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Slug</label>
        <input type="text"
               name="slug"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Thứ tự sắp xếp</label>
        <input type="number"
               name="sort_order"
               class="form-control"
               value="0">
    </div>

    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description"
                  class="form-control"
                  rows="4"></textarea>
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1">Hiển thị</option>
            <option value="0">Ẩn</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Lưu
    </button>

    <a href="{{ route('brand.index') }}"
       class="btn btn-secondary">
        Quay lại
    </a>
</form>
@endsection
