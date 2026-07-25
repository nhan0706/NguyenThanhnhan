<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'My Web')</title>

    <!-- {{-- CDN Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- CDN Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css"> -->
    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- Summernote CSS & JS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            {{-- SIDEBAR --}}
            <div class="col-md-2 bg-dark text-white p-0">
                @include('admin._partials.sidebar')
            </div>

            {{-- RIGHT CONTENT --}}
            <div class="col-md-10 d-flex flex-column p-0">
                {{-- HEADER --}}
                <div class="border-bottom bg-white">
                    @include('admin._partials.header')
                </div>

                {{-- MAIN CONTENT --}}
                <main class="flex-grow-1 bg-light p-3">
                    @yield('content')
                </main>

                {{-- FOOTER --}}
                <footer class="bg-dark text-white text-center py-2">
                    @include('admin._partials.footer')
                </footer>
            </div>
        </div>
    </div>

    {{-- CDN Bootstrap JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/preview-image.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            if ($('.summernote').length > 0) {
                $('.summernote').summernote({
                    placeholder: 'Nhập nội dung chi tiết...',
                    tabsize: 2,
                    height: 250,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview']]
                    ]
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>