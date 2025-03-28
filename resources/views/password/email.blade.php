
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    @if (app()->environment('production'))
    <!-- If running on Railway (production environment) -->
    <link rel="stylesheet" href="https://medsecure-teleportal-production.up.railway.app/css/app.css">
    @else
        <!-- If running locally or in a non-production environment -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif

</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="form-container">
            <h2 class="text-center">Forgot Your Password?</h2>

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


            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
            </form>

            <div class="mt-3">
                <p>Remember your password? <a href="{{ route('patients.login') }}">Login here</a>.</p>
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
