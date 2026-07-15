@extends('admin.layouts.admin')

@section('title', 'Trash - Sản phẩm')

@section('content')
    <h2 class="mb-3">DANH SÁCH SẢN PHẨM - ĐANG CHỜ XÓA</h2>

    <x-admin.alert />

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left-circle"></i>
                Quay lại danh sách
            </a>
            <span class="badge bg-warning text-dark ms-2">Số lượng trong thùng rác: {{ $trashCount }}</span>
        </div>

        <div class="d-flex gap-2">
            <form action="{{ route('admin.product.restoreAll') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">Khôi phục tất cả</button>
            </form>

            <form action="{{ route('admin.product.forceDeleteAll') }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa vĩnh viễn tất cả?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Xóa vĩnh viễn tất cả</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Loại</th>
                <th>Thương hiệu</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($list as $index => $item)
                <tr>
                    <td>{{ $list->firstItem() + $index }}</td>
                    <td>
                        @if($item->image)
                            <img src="{{ asset('storage/products/' . $item->image) }}" alt="{{ $item->productname }}" class="img-thumbnail" width="80">
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $item->productname }}</td>
                    <td>{{ $item->category?->catename }}</td>
                    <td>{{ $item->brand?->brandname }}</td>
                    <td>{{ number_format($item->price, 0) }} đ</td>
                    <td>
                        @if ($item->status == 1)
                            <span class="badge bg-success">Hiện</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.product.restore', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Khôi phục</button>
                        </form>

                        <form action="{{ route('admin.product.forceDelete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn sản phẩm này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Không có sản phẩm nào trong thùng rác.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $list->links() }}
    </div>
@endsection
