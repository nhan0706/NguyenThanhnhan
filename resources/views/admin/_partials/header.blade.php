<nav class="navbar navbar-light bg-light admin-header">
    <div class="container-fluid">
        <span class="navbar-brand">Admin Panel</span>
        <ul class="nav align-items-center">
            <li class="nav-item me-3">
                <span class="nav-link">Xin chào <strong>{{ Auth::user()?->fullname ?? 'Khách' }}</strong></span>
            </li>
            <li class="nav-item">
                <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link p-0 text-decoration-none">Đăng xuất</button>
                </form>
            </li>
        </ul>
    </div>
</nav>