<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, {{ Auth::guard('doctors')->user()->first_name }}</h2>
        <p>This is your dashboard.</p>

         <!-- Logout Form -->
         <form action="{{ route('doctors.logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
