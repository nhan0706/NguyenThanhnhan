<div class="card product-card h-100 position-relative">
    @if ($product->pricediscount > 0 && $product->price > 0)
        @php
            $percent = round((($product->price - $product->pricediscount) / $product->price) * 100);
        @endphp
        <span class="position-absolute top-0 end-0 badge-discount text-white px-2 py-1 m-2 rounded-pill fw-bold" style="font-size: 0.75rem; z-index: 10;">
            -{{ $percent }}%
        </span>
    @endif

    {{-- Hình ảnh --}}
    <div class="product-img-wrapper overflow-hidden text-center" style="height: 180px;">
        <img src="{{ asset('storage/products/'.$product->image) }}"
            class="card-img-top w-100 h-100" alt="{{ $product->productname }}"
            style="object-fit: cover;"
            onerror="this.onerror=null;this.src='{{ asset('images/default.png') }}';">
    </div>

    <div class="card-body d-flex flex-column p-3">
        {{-- Danh mục / Thương hiệu --}}
        @if($product->category || $product->brand)
            <div class="d-flex align-items-center justify-content-between mb-1">
                @if($product->category)
                    <span class="product-category text-uppercase">
                        {{ $product->category->catename }}
                    </span>
                @else
                    <span></span>
                @endif
                @if($product->brand)
                    <span class="product-brand-badge">
                        {{ $product->brand->brandname }}
                    </span>
                @endif
            </div>
        @endif

        {{-- Tên sản phẩm --}}
        <h6 class="product-title mb-2" title="{{ $product->productname }}">
            {{ $product->productname }}
        </h6>

        {{-- Giá --}}
        <div class="mb-3">
            @if ($product->pricediscount > 0)
                <div class="product-price text-danger">
                    {{ number_format($product->pricediscount) }} đ
                </div>
                <div class="product-old-price">
                    {{ number_format($product->price) }} đ
                </div>
            @else
                <div class="product-price text-danger">
                    {{ number_format($product->price) }} đ
                </div>
            @endif
        </div>

        {{-- Nút chức năng --}}
        <div class="mt-auto">
            <div class="row g-2">
                <div class="col-6">
                    <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="btn btn-outline-primary btn-sm w-100 fw-bold" title="Xem chi tiết">
                        <i class="bi bi-eye me-1"></i> Xem
                    </a>
                </div>
                <div class="col-6">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="form-add-cart">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold" title="Thêm vào giỏ">
                            <i class="bi bi-cart-plus me-1"></i> Mua
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>