<div class="admin-sidebar bg-dark text-white p-3 vh-100">
    <h4 class="mb-4">
        <i class="bi bi-speedometer2"></i>
        Admin
    </h4>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.home') }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="/admin/dashboard">
                <i class="bi bi-house-door"></i> Dashboard***
            </a>
        </li>
        
        {{-- Menu expand --}}
        <li class="nav-item">
            <a class="nav-link text-white" 
               data-bs-toggle="collapse" 
               href="#categoryMenu" 
               role="button" 
               aria-expanded="false" 
               aria-controls="categoryMenu">
                <i class="bi bi-tags"></i>
                Quan ly danh muc
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            
            <div class="collapse" id="categoryMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('category.index') }}">
                            Danh sách loại sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            Thêm loại sản phẩm
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        {{-- Menu Brand --}}
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
                        <a class="nav-link text-white" href="{{ route('brand.index') }}">
                            Danh sách thương hiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            Thêm thương hiệu
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Menu User --}}
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
                        <a class="nav-link text-white" href="{{ route('user.index') }}">
                            Danh sách người dùng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            Thêm người dùng
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Menu Product --}}
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
                        <a class="nav-link text-white" href="{{ route('product.index') }}">
                            Danh sách sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            Thêm sản phẩm
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Menu Post --}}
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
                        <a class="nav-link text-white" href="{{ route('post.index') }}">
                            Danh sách bài viết
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            Thêm bài viết
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
