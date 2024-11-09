<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light ps-3 pe-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('medsecure_logo.png') }}" alt="Logo" style="height: 50px;">
            </a>

            <!-- Patient name and logout button on the right side -->
            <div class="d-flex justify-content-end align-items-center">
                <span id="current-date-time" class="me-5"></span>
                <span class="fw-semibold me-3">Welcome, {{ Auth::guard('admin')->user()->first_name }}</span>
                <form action="{{ route('admin.logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mt-5">
        <p>This is your dashboard.</p>
    </div>


    <footer class="footer bg-light text-center py-3">
        &copy; 2024 MedSecure. All rights reserved.
    </footer>


    

    

    <script src="{{ asset('js/app.js') }}"></script>


    <script>
        function updateDateTime() {
            const dateTimeElement = document.getElementById('current-date-time');
            const now = new Date();
            
            // Format the date (e.g., "November 9, 2024")
            const date = now.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            // Format the time (e.g., "14:30:15")
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const time = `${hours}:${minutes}:${seconds}`;
            
            // Set the formatted date and time
            dateTimeElement.textContent = `${date} ${time}`;
        }

        // Update the date and time every second
        setInterval(updateDateTime, 1000);

        // Set initial date and time on page load
        updateDateTime();
    </script>
</body>
</html>
