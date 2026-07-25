<div class="bg-dark text-white py-2">
    <div class="container">
        <div class="row align-items-center">
            {{-- Thông tin liên hệ --}}
            <div class="col-md-6">
                <small>
                    Hotline: 0909 999 999 |
                    ✉ Email: support@minishop.com
                </small>
            </div>
            {{-- Tài khoản --}}
            <div class="col-md-6 text-md-end">
                <small>
                    @auth
                        <span class="text-warning me-3">
                            <i class="bi bi-person-circle"></i> Xin chào, {{ Auth::user()->fullname ?? Auth::user()->username }}
                        </span>
                        @if(in_array(Auth::user()->role, [1, 2]))
                            <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none me-3">
                                <i class="bi bi-speedometer2"></i> Quản trị
                            </a>
                        @endif
                        <form action="{{ route('client.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link text-white text-decoration-none p-0 border-0 align-baseline" style="font-size: inherit;">
                                <i class="bi bi-box-arrow-right"></i> Đăng xuất
                            </button>
                        </form>
                    @else
                        <a href="{{ route('client.login') }}" class="text-white text-decoration-none me-3">
                            <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
                        </a>
                        <a href="{{ route('client.register') }}" class="text-white text-decoration-none me-3">
                            <i class="bi bi-person-plus"></i> Đăng ký
                        </a>
                    @endauth
                </small>
            </div>
        </div>
    </div>
</div>
