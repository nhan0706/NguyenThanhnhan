<div class="admin-sidebar bg-dark text-white p-3 vh-100">
    <h4 class="mb-4">
        <i class="bi bi-speedometer2"></i>
        Admin
    </h4>
    
    <ul class="nav flex-column">
        {{-- Menu Dashboard --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>
        
        {{-- Menu Danh mục --}}
        <li class="nav-item">
            <a class="nav-link text-white" 
               data-bs-toggle="collapse" 
               href="#categoryMenu" 
               role="button" 
               aria-expanded="false" 
               aria-controls="categoryMenu">
                <i class="bi bi-tags"></i>
                Quản lý danh mục
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            
            <div class="collapse" id="categoryMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.category.index') }}">
                            Danh sách loại sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.category.create') }}">
                            Thêm loại sản phẩm
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        {{-- Menu Thương hiệu --}}
        <li class="nav-item">
            <a class="nav-link text-white" 
               data-bs-toggle="collapse" 
               href="#brandMenu" 
               role="button" 
               aria-expanded="false" 
               aria-controls="brandMenu">
                <i class="bi bi-award"></i>
                Quản lý thương hiệu
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            
            <div class="collapse" id="brandMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.brand.index') }}">
                            Danh sách thương hiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.brand.create') }}">
                            Thêm thương hiệu
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Menu Người dùng --}}
        <li class="nav-item">
            <a class="nav-link text-white" 
               data-bs-toggle="collapse" 
               href="#userMenu" 
               role="button" 
               aria-expanded="false" 
               aria-controls="userMenu">
                <i class="bi bi-people"></i>
                Quản lý người dùng
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            
            <div class="collapse" id="userMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.user.index') }}">
                            Danh sách người dùng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.user.create') }}">
                            Thêm người dùng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.password.change') }}">
                            Đổi mật khẩu
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Menu Sản phẩm --}}
        <li class="nav-item">
            <a class="nav-link text-white" 
               data-bs-toggle="collapse" 
               href="#productMenu" 
               role="button" 
               aria-expanded="false" 
               aria-controls="productMenu">
                <i class="bi bi-box-seam"></i>
                Quản lý sản phẩm
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            
            <div class="collapse" id="productMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.product.index') }}">
                            Danh sách sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.product.create') }}">
                            Thêm sản phẩm
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Menu Bài viết --}}
        <li class="nav-item">
            <a class="nav-link text-white" 
               data-bs-toggle="collapse" 
               href="#postMenu" 
               role="button" 
               aria-expanded="false" 
               aria-controls="postMenu">
                <i class="bi bi-file-earmark-text"></i>
                Quản lý bài viết
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            
            <div class="collapse" id="postMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.post.index') }}">
                            Danh sách bài viết
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.post.create') }}">
                            Thêm bài viết
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>