@extends('admin.layouts.admin')
@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Chi tiết đơn hàng: {{ $order->order_code }}</h4>
        <div>
            <a href="{{ route('admin.order.index') }}" class="btn btn-sm btn-secondary">Quay về</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-dark text-white fw-bold">Thông tin khách hàng</div>
                <div class="card-body">
                    <p><strong>Họ tên:</strong> {{ $order->customer?->fullname ?? $order->customer?->name ?? 'Khách' }}</p>
                    <p><strong>Email:</strong> {{ $order->customer?->email ?? '-' }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->customer?->phone ?? '-' }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->customer?->address ?? ($order->customer?->city ?? '-') }}</p>
                    <p><strong>Ghi chú:</strong> {{ $order->note ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-dark text-white fw-bold">Thông tin đơn hàng</div>
                <div class="card-body">
                    <p><strong>Mã đơn:</strong> {{ $order->order_code }}</p>
                    <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">{{ number_format($order->total_amount) }} VNĐ</span></p>
                    <p><strong>Trạng thái đơn:</strong> <span class="badge {{ $order->status_badge }}">{{ $order->status_label }}</span></p>
                    <p><strong>Trạng thái thanh toán:</strong> <span class="badge {{ $order->payment_status_badge }}">{{ $order->payment_status_label }}</span></p>
                    <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white fw-bold">Cập nhật trạng thái</div>
                <div class="card-body">
                    <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status_id" class="form-label fw-semibold">Trạng thái đơn hàng</label>
                            <select name="status_id" id="status_id" class="form-select">
                                @foreach(\App\Models\Order::getStatusesList() as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status_id == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label fw-semibold">Trạng thái thanh toán</label>
                            <select name="payment_status" id="payment_status" class="form-select">
                                @foreach(\App\Models\Order::getPaymentStatusesList() as $key => $label)
                                    <option value="{{ $key }}" {{ $order->payment_status == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save"></i> Lưu cập nhật
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Sản phẩm</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="width:80px">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/products/' . $item->product->image) }}" alt="{{ $item->product->productname }}" class="img-fluid" style="max-height:60px;">
                                @else
                                    <img src="{{ asset('images/default.png') }}" alt="no-image" class="img-fluid" style="max-height:60px;">
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->product?->productname ?? 'Sản phẩm không xác định' }}</strong>
                                <div class="text-muted">ID: {{ $item->product_id }}</div>
                            </td>
                            <td>{{ number_format($item->price) }} VNĐ</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price * $item->quantity) }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
