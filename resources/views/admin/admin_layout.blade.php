<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @if (app()->environment('production'))
        <!-- If running on Railway (production environment) -->
        <link rel="stylesheet" href="https://medsecure-teleportal-production.up.railway.app/css/app.css">
    @else
        <!-- If running locally or in a non-production environment -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif


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
        <div class="text-center mb-5">
            <img src="{{ asset('medsecure_logo.png') }}" alt="Logo" style="height: 60px;" id="desktop-logo" class="sidebar-logo">
            <img src="{{ asset('m-logo.png') }}" alt="Logo" style="height: 60px;"  id="mobile-logo" class="sidebar-logo d-none">
        </div>
        
        <a href="{{ route('doctors.doctor-dashboard') }}" class="sidebar-link">
            <i class="fas fa-tachometer-alt"></i>
            <span class="sidebar-text">Dashboard</span>
        </a>
        <a href="{{ route('doctors.profile') }}" class="sidebar-link">
            <i class="fas fa-user"></i>
            <span class="sidebar-text">Profile</span>
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
                <span class="fw-semibold me-3">Welcome, {{ Auth::guard('admin')->user()->first_name }}</span>
                <form action="{{ route('admin.logout') }}" method="POST" class="mb-0">
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


  

    @if (app()->environment('production'))
    <!-- If running on Railway (production environment) -->
    <script src="https://medsecure-teleportal-production.up.railway.app/js/app.js"></script>
    @else
        <!-- If running locally or in a non-production environment -->
        <script src="{{ asset('js/app.js') }}"></script>
    @endif



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
            const content = document.querySelector('.content');
            const navbar = document.querySelector('.navbar');
            const mobileLogo = document.getElementById('mobile-logo');

            // Toggle the 'collapsed' class on the sidebar and content
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
            navbar.classList.toggle('collapsed');
            
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
