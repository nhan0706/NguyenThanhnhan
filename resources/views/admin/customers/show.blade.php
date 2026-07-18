@extends('admin.layouts.admin')

@section('title', 'Chi tiết khách hàng')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary btn-sm">
        Quay lại
    </a>
</div>

<h2 class="mb-4">CHI TIẾT KHÁCH HÀNG</h2>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0">Thông tin cá nhân</h5>
            </div>
            <div class="card-body">
                <p><strong>Mã KH:</strong> #{{ $customer->id }}</p>
                <p><strong>Họ và tên:</strong> {{ $customer->fullname }}</p>
                <p><strong>Email:</strong> {{ $customer->email ?: 'N/A' }}</p>
                <p><strong>Số điện thoại:</strong> {{ $customer->phone ?: 'N/A' }}</p>
                <p><strong>Địa chỉ:</strong> {{ $customer->address ?: 'N/A' }}</p>
                <p><strong>Ngày tạo tài khoản:</strong> {{ $customer->created_at->format('d/m/Y H:i') }}</p>
                <a href="{{ route('admin.customer.edit', $customer->id) }}" class="btn btn-warning w-100 text-white">Chỉnh sửa</a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Lịch sử mua hàng</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Ngày Đặt</th>
                            <th>Trạng Thái</th>
                            <th>Thanh Toán</th>
                            <th>Tổng Tiền</th>
                            <th>Chức Năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer->orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.order.show', $order->id) }}" class="fw-bold text-decoration-none">
                                    {{ $order->order_code }}
                                </a>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge {{ $order->status_badge }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $order->payment_status_badge }}">
                                    {{ $order->payment_status_label }}
                                </span>
                            </td>
                            <td class="fw-bold text-danger">
                                {{ number_format($order->total_amount, 0, ',', '.') }}đ
                            </td>
                            <td>
                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-info text-white btn-sm">Xem chi tiết</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Khách hàng chưa có đơn hàng nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
