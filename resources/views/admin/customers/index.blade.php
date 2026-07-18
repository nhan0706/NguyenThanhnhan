@extends('admin.layouts.admin')

@section('title', 'Khách hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>DANH SÁCH KHÁCH HÀNG</h2>
    <form action="{{ route('admin.customer.index') }}" method="GET" class="d-flex gap-2" style="max-width: 400px;">
        <input type="text" name="search" class="form-control" placeholder="Tìm tên, email, sđt..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Tìm</button>
        @if(request('search'))
            <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary">Clear</a>
        @endif
    </form>
</div>

<x-admin.alert />

<div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table class="table table-bordered table-hover table-striped mb-0">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Mã KH</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Số đơn hàng</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @forelse($list as $index => $item)
            <tr>
                <td>{{ ($list->currentPage() - 1) * $list->perPage() + $index + 1 }}</td>
                <td>{{ $item->id }}</td>
                <td>
                    <a href="{{ route('admin.customer.show', $item->id) }}" class="fw-bold text-decoration-none">
                        {{ $item->fullname }}
                    </a>
                </td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->address }}</td>
                <td>
                    <span class="badge bg-info text-white">
                        {{ $item->orders()->count() }}
                    </span>
                </td>
                <td class="d-flex gap-1">
                    <a href="{{ route('admin.customer.show', $item->id) }}" class="btn btn-info text-white btn-sm">Xem</a>
                    <a href="{{ route('admin.customer.edit', $item->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.customer.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" @if($item->orders()->count() > 0) disabled title="Không thể xóa khi có đơn hàng" @endif>Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted">Không tìm thấy khách hàng nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $list->links() }}
</div>
@endsection
