@extends('admin.layouts.admin')
@section('title', 'Danh sách đơn hàng')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-dark fw-bold">Quản lý Đơn hàng</h4>
    </div>

    <!-- Thống kê doanh thu & đơn hàng -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 fs-1 text-white-50">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <small class="text-white-50 d-block text-uppercase fw-semibold" style="font-size: 0.75rem;">Tổng số đơn hàng</small>
                        <h4 class="mb-0 fw-bold">{{ number_format($totalOrders) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 fs-1 text-white-50">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <small class="text-white-50 d-block text-uppercase fw-semibold" style="font-size: 0.75rem;">Doanh thu (Đã hoàn thành)</small>
                        <h4 class="mb-0 fw-bold">{{ number_format($totalRevenue) }} VNĐ</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bộ lọc tìm kiếm -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.order.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-9">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-light border-start-0" 
                               placeholder="Tìm kiếm theo mã đơn, họ tên, sđt hoặc email khách hàng..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-12 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        Tìm kiếm
                    </button>
                    @if(request()->filled('search'))
                        <a href="{{ route('admin.order.index') }}" class="btn btn-outline-secondary">
                            Xóa lọc
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thanh toán</th>
                    <th>Phương thức</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration + ($orders->currentPage()-1) * $orders->perPage() }}</td>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->customer?->fullname ?? $order->customer?->name ?? 'Khách' }}</td>
                        <td>{{ number_format($order->total_amount) }} VNĐ</td>
                        <td>
                            <span class="badge {{ $order->status_badge }}">{{ $order->status_label }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $order->payment_status_badge }}">{{ $order->payment_status_label }}</span>
                        </td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-primary">Xem</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">Không có đơn hàng</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>
@endsection
