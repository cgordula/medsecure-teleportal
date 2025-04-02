<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login</title>
    @if (app()->environment('production'))
    <!-- If running on Railway (production environment) -->
    <link rel="stylesheet" href="https://medsecure-teleportal-production.up.railway.app/css/app.css">
    @else
        <!-- If running locally or in a non-production environment -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif

</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100 flex-column">
    <img src="{{ asset('medsecure_logo.png') }}" alt="MedSecure Logo" class="mb-5" style="max-width: 200px;">
    
    <div class="login-form-container">
        <h2 class="text-center">Doctor Login</h2>

        @if (session('success'))
            <div id="success-message" class="alert alert-success">
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

        <form action="{{ route('doctors.login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-primary w-50">Login</button>
        </form>

        <div class="mt-3">
            <p>Don't have an account? <a href="{{ route('doctors.register') }}">Register here</a>.</p>
        </div>
    </div>
</div>


    @if (app()->environment('production'))
    <!-- If running on Railway (production environment) -->
    <script src="https://medsecure-teleportal-production.up.railway.app/js/app.js"></script>
    @else
        <!-- If running locally or in a non-production environment -->
        <script src="{{ asset('js/app.js') }}"></script>
    @endif

</body>
</html>
