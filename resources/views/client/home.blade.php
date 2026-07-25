@extends('client.layouts.app')

@section('title', 'Trang chủ')

@section('content')
    <!-- Hero Banner Carousel -->
    <div id="heroCarousel" class="carousel slide mb-5 shadow-sm rounded-4 overflow-hidden" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="height: 400px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                <div class="carousel-caption d-none d-md-block text-start h-100 d-flex flex-column justify-content-center">
                    <h1 class="display-4 fw-bold">Chào mừng đến với Mini Shop</h1>
                    <p class="lead text-white-50">Nơi mua sắm các sản phẩm công nghệ chất lượng hàng đầu với giá cả hợp lý.</p>
                    <div>
                        <a href="#new-products" class="btn btn-warning btn-lg fw-bold text-dark px-4 py-2">Khám phá ngay</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="height: 400px; background: linear-gradient(135deg, #f12711 0%, #f5af19 100%);">
                <div class="carousel-caption d-none d-md-block text-start h-100 d-flex flex-column justify-content-center">
                    <h1 class="display-4 fw-bold">Siêu Khuyến Mãi Hè</h1>
                    <p class="lead text-white-50">Giảm giá cực sốc lên đến 30% cho các dòng sản phẩm chọn lọc.</p>
                    <div>
                        <a href="#sale-products" class="btn btn-dark btn-lg fw-bold text-white px-4 py-2">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="height: 400px; background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);">
                <div class="carousel-caption d-none d-md-block text-start h-100 d-flex flex-column justify-content-center">
                    <h1 class="display-4 fw-bold">Thương Hiệu Uy Tín</h1>
                    <p class="lead text-white-50">Đảm bảo hàng chính hãng 100% từ các nhà cung cấp uy tín.</p>
                    <div>
                        <a href="#new-products" class="btn btn-light btn-lg fw-bold text-dark px-4 py-2">Xem sản phẩm</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container">
        {{-- ===================== SẢN PHẨM MỚI ===================== --}}
        <h3 id="new-products" class="mb-4 text-uppercase border-start border-success border-4 ps-2">Sản phẩm mới nhất</h3>
        <div class="row">
            @foreach ($newProducts as $product)
                <div class="col-6 col-md-3 mb-4">
                    <x-client.product :product="$product" />
                </div>
            @endforeach
        </div>

        {{-- ===================== SẢN PHẨM GIẢM GIÁ ===================== --}}
        <h3 id="sale-products" class="mt-5 mb-4 text-uppercase border-start border-danger border-4 ps-2">Sản phẩm đang giảm giá</h3>
        <div class="row">
            @foreach ($saleProducts as $product)
                <div class="col-6 col-md-3 mb-4">
                    <x-client.product :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
@endsection
