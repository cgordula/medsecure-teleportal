<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
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
    <div class="form-container">
        <h2 class="text-center">Patient Registration</h2>
        
        @if (session('success'))
            <div id="success-message" class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div id="error-message" class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                </div>
                <div class="col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary w-50">Register</button>
            </div>
        </form>

        <div class="mt-3 text-center">
            <p>Already have an account? <a href="{{ route('patients.login') }}">Log in here</a>.</p>
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
