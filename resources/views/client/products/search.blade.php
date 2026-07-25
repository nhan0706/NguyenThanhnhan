@extends('client.layouts.app')

@section('title', 'Tìm kiếm sản phẩm')

@section('content')
<div class="container py-4">

    <h3 class="mb-4">
        Kết quả tìm kiếm
        @if($keyword)
            cho: <span class="text-primary">{{ $keyword }}</span>
        @endif
    </h3>

    <form action="{{ route('products.search') }}" method="GET" class="row g-3 mb-4">

        {{-- Từ khóa --}}
        <div class="col-md-4">
            <input type="text"
                   name="keyword"
                   value="{{ request('keyword') }}"
                   class="form-control"
                   placeholder="Tìm theo tên sản phẩm">
        </div>

        {{-- Giá tối thiểu --}}
        <div class="col-md-2">
            <input type="number"
                   name="min_price"
                   value="{{ request('min_price') }}"
                   class="form-control"
                   placeholder="Giá tối thiểu">
        </div>

        {{-- Giá tối đa --}}
        <div class="col-md-2">
            <input type="number"
                   name="max_price"
                   value="{{ request('max_price') }}"
                   class="form-control"
                   placeholder="Giá tối đa">
        </div>

        {{-- Sắp xếp --}}
        <div class="col-md-2">
            <select name="sort_by" id="sort_by" class="form-select">
                <option value="productname"
                    {{ request('sort_by','productname') == 'productname' ? 'selected' : '' }}>
                    Tên
                </option>

                <option value="price"
                    {{ request('sort_by') == 'price' ? 'selected' : '' }}>
                    Giá
                </option>
            </select>
        </div>

        {{-- Hướng sắp xếp --}}
        <div class="col-md-2" id="sort-direction-group">
            <select name="sort_direction" class="form-select">
                <option value="asc"
                    {{ request('sort_direction','asc') == 'asc' ? 'selected' : '' }}>
                    Tăng dần
                </option>

                <option value="desc"
                    {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>
                    Giảm dần
                </option>
            </select>
        </div>

        <div class="col-12">
            <button class="btn btn-primary">
                Tìm kiếm
            </button>

            <a href="{{ route('products.search') }}"
               class="btn btn-outline-secondary">
                Xóa bộ lọc
            </a>
        </div>

    </form>

    @if($products->count())

        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <x-client.product :product="$product"/>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $products->appends(request()->query())->links() }}
        </div>

    @else

        <div class="alert alert-warning">
            Không tìm thấy sản phẩm phù hợp.
        </div>

    @endif

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const sortBy = document.getElementById('sort_by');
    const direction = document.getElementById('sort-direction-group');

    function toggleDirection() {

        if (sortBy.value === 'price') {
            direction.style.display = 'block';
        } else {
            direction.style.display = 'none';
        }

    }

    toggleDirection();

    sortBy.addEventListener('change', toggleDirection);

});
</script>
@endpush