<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="mb-4">Quên mật khẩu</h2>

                        <x-admin.alert />

                        <form action="{{ route('admin.forgotpass.post') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="f-email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="f-email" name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Gửi</button>
                                <a href="{{ route('admin.login') }}" class="btn btn-warning">Đăng nhập</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
