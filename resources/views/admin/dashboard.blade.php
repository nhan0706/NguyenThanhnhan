@extends('admin.layouts.admin')

@section('title', 'Bảng Điều Khiển Admin')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">BẢNG ĐIỀU KHIỂN</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <span class="badge bg-secondary p-2">{{ now()->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Products Card -->
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase text-white-50 mb-1">Tổng sản phẩm</h6>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalProducts) }}</h2>
                    </div>
                    <div class="fs-1 opacity-75">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.product.index') }}" class="text-white text-decoration-none small">
                        Xem chi tiết <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase text-white-50 mb-1">Tổng đơn hàng</h6>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalOrders) }}</h2>
                    </div>
                    <div class="fs-1 opacity-75">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.order.index') }}" class="text-white text-decoration-none small">
                        Xem chi tiết <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Categories Card -->
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase text-white-50 mb-1">Danh mục</h6>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalCategories) }}</h2>
                    </div>
                    <div class="fs-1 opacity-75">
                        <i class="bi bi-tags"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.category.index') }}" class="text-white text-decoration-none small">
                        Xem chi tiết <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="col-md-3">
            <div class="card bg-warning text-dark shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase text-black-50 mb-1">Doanh thu (Hoàn thành)</h6>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h2>
                    </div>
                    <div class="fs-1 opacity-75">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.order.index') }}" class="text-dark text-decoration-none small">
                        Xem chi tiết <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Lists -->
    <div class="row g-4">
        <!-- Newest Products -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">5 Sản phẩm mới nhất</h5>
                    <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn-outline-light">Tất cả</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestProducts as $prod)
                            <tr>
                                <td>
                                    @if($prod->image)
                                        <img src="{{ asset('storage/' . $prod->image) }}" alt="{{ $prod->productname }}" width="45" height="45" class="object-fit-cover rounded" onerror="this.onerror=null;this.src='{{ asset('images/default.png') }}';">
                                    @else
                                        <img src="{{ asset('images/default.png') }}" alt="{{ $prod->productname }}" width="45" height="45" class="object-fit-cover rounded">
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $prod->productname }}</div>
                                    <small class="text-muted">{{ $prod->brand?->brandname }}</small>
                                </td>
                                <td>{{ $prod->category?->catename }}</td>
                                <td>
                                    @if($prod->pricediscount > 0)
                                        <div class="text-danger fw-bold">{{ number_format($prod->pricediscount, 0, ',', '.') }}đ</div>
                                        <del class="text-muted small">{{ number_format($prod->price, 0, ',', '.') }}đ</del>
                                    @else
                                        <div class="fw-bold">{{ number_format($prod->price, 0, ',', '.') }}đ</div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Không có sản phẩm nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Newest Orders -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">5 Đơn hàng mới nhất</h5>
                    <a href="{{ route('admin.order.index') }}" class="btn btn-sm btn-outline-light">Tất cả</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestOrders as $ord)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.order.show', $ord->id) }}" class="fw-bold text-decoration-none text-dark">
                                        {{ $ord->order_code }}
                                    </a>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $ord->customer?->fullname }}</div>
                                    <small class="text-muted">{{ $ord->customer?->phone }}</small>
                                </td>
                                <td class="text-danger fw-bold">
                                    {{ number_format($ord->total_amount, 0, ',', '.') }}đ
                                </td>
                                <td>
                                    <span class="badge {{ $ord->status_badge }}">
                                        {{ $ord->status_label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Không có đơn hàng nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection