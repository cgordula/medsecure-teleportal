<!-- resources/views/layouts/patient_layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Sidebar styling when collapsed */
        .sidebar.collapsed #desktop-logo {
            display: none;
        }

        .sidebar.collapsed #mobile-logo {
            display: block;
        }


        /* For screens smaller than or equal to 767px, show the mobile logo */
        @media (max-width: 767px) {
            #desktop-logo {
                display: none;
            }
            #mobile-logo {
                display: block !important;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('medsecure_logo.png') }}" alt="Logo" style="height: 60px;" id="desktop-logo" class="sidebar-logo">
            <img src="{{ asset('m-logo.png') }}" alt="Logo" style="height: 60px;"  id="mobile-logo" class="sidebar-logo d-none">
        </div>
        
        <a href="{{ route('patients.patient-dashboard') }}" class="sidebar-link">
            <i class="fas fa-tachometer-alt"></i>
            <span class="sidebar-text">Dashboard</span>
        </a>
        <a href="{{ route('patients.profile') }}" class="sidebar-link">
            <i class="fas fa-user"></i>
            <span class="sidebar-text">Profile</span>
        </a>
        <a href="{{ route('patients.create-appointment') }}" class="sidebar-link">
            <i class="fas fa-calendar-plus"></i>
            <span class="sidebar-text">Create Appointment</span>
        </a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light ps-3 pe-3">
        <div class="container-fluid">
            <button class="btn btn-outline-secondary" onclick="toggleSidebar()">
                ☰
            </button>
        

            <div class="d-flex flex-grow-1"></div>
            <!-- Right side content -->
            <div class="d-flex justify-content-end align-items-center">
                <span id="current-date-time" class="me-5"></span>
                <span class="fw-semibold me-3">Welcome, {{ Auth::guard('patients')->user()->first_name }}</span>
                <form action="{{ route('patients.logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        @yield('content') <!-- This will render the specific page content -->
    </div>

    <!-- Footer -->
    <footer class="footer bg-light text-center py-3">
        &copy; 2024 MedSecure. All rights reserved.
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function updateDateTime() {
            const dateTimeElement = document.getElementById('current-date-time');
            const now = new Date();
            const date = now.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const time = `${hours}:${minutes}:${seconds}`;
            dateTimeElement.textContent = `${date} ${time}`;
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

    <script>
         function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mobileLogo = document.getElementById('mobile-logo');
            
            // Toggle the 'collapsed' class on the sidebar
            sidebar.classList.toggle('collapsed');
            
            // Show the mobile logo if the sidebar is collapsed
            if (sidebar.classList.contains('collapsed')) {
                mobileLogo.classList.remove('d-none');
            } else {
                mobileLogo.classList.add('d-none');
            }
        }
    </script>

</body>
</html>
