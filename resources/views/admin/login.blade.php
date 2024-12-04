<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container-fluid min-vh-100 d-flex align-items-center">
        <div class="form-container">
            <h2 class="text-center">Admin Login</h2>

            @if (session('success'))
                <div class="alert alert-success" id="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div id="error-message" class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <div class="mt-3 text-center">
                <p>Don't have an account? <a href="{{ route('admin.register') }}">Register here</a>.</p>
            </div>
            
        </div>
        
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
