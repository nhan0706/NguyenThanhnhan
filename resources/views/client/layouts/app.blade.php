<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - My web</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @vite(['resources/css/client.css', 'resources/js/client.js'])
</head>
<body class="d-flex flex-column min-vh-100">
    {{-- ===================== HEADER TOP ===================== --}}
    @include('client._partials.header')

    {{-- ===================== NAVBAR ===================== --}}
    @include('client._partials.navbar')

    {{-- ===================== CONTENT ===================== --}}
    <main class="container mt-3 flex-grow-1">
        @yield('content')
    </main>

    {{-- ===================== FOOTER ===================== --}}
    @include('client._partials.footer')

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: "{{ session('error') }}",
                    confirmButtonText: 'Đóng'
                });
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>
