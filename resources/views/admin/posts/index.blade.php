{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Bài viết')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">DANH SÁCH BÀI VIẾT</h2>

@if(session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.post.create') }}" class="btn btn-success mb-3">
    + Thêm mới
</a>

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Tiêu đề</th>
            <th>Hình ảnh</th>
            <th>Tác giả</th>
            <th>Trạng thái</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $index + 1 }}</td>
            <td>{{ $item->title }}</td>
            <td>
                @if($item->image)
                    <img src="{{ asset('images/' . $item->image) }}" alt="Image" width="50">
                @else
                    <img src="{{ asset('images/default.png') }}" alt="Default" width="50">
                @endif
            </td>
            <td>{{ $item->user->fullname ?? 'N/A' }}</td>
            <td>
                @if($item->status == 1)
                    <span class="badge bg-success">Hiển thị</span>
                @else
                    <span class="badge bg-danger">Ẩn</span>
                @endif
            </td>
            <td class="d-flex gap-1">
                <a href="{{ route('admin.post.edit', $item->id) }}" class="btn btn-warning btn-sm">Sửa</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $list->links() }}
</div>
@endsection
