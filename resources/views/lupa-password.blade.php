<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Lupa Password</div>
                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success">{!! session('status') !!}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ url('/lupa-password/proses') }}">
                            @csrf
                            <div class="mb-3">
                                <label>Email Anda</label>
                                <input type="email" name="email" class="form-control" required>
                                <small class="text-muted">Masukkan email yang terdaftar</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
                            <a href="{{ url('/login') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>