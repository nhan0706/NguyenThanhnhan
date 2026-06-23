{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thêm Bài viết')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">THÊM MỚI BÀI VIẾT</h2>

@if(session('error'))
    <div class="alert alert-danger mb-3">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('admin.post.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Tiêu đề</label>
        <input type="text"
               name="title"
               class="form-control"
               value="{{ old('title') }}">
    </div>

    <div class="mb-3">
        <label>Slug</label>
        <input type="text"
               name="slug"
               class="form-control"
               value="{{ old('slug') }}">
    </div>

    <div class="mb-3">
        <label>Nội dung</label>
        <textarea name="content"
                  class="form-control"
                  rows="6">{{ old('content') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Tác giả</label>
        <select name="user_id" class="form-control">
            <option value="">-- Chọn tác giả --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->fullname }}
                </option>
            @endforeach
        </select>
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
    <a href="{{ route('admin.post.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
