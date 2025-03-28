<!-- resources/views/layouts/patient_layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    @if (app()->environment('production'))
    <!-- If running on Railway (production environment) -->
        <link rel="stylesheet" href="https://medsecure-teleportal-production.up.railway.app/css/app.css">
    @else
        <!-- If running locally or in a non-production environment -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Include moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

   <!-- FullCalendar Core -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>

    <!-- FullCalendar DayGrid (Month view) -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        /* Dashboard content layout */
        .dashboard-header, .appointment-header, .profile-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 20px;
        }

        .dashboard-header h1, .appointment-header h1, .profile-header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        /* Dashboard Summary Section */
        .dashboard-summary {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex-wrap: wrap; /* Allow items to wrap on smaller screens */
        }

        .summary-item {
            text-align: center;
            flex: 1 1 calc(33.333% - 20px); /* Default: 3 items per row */
            margin: 10px 0;
        }

        .summary-item h3 {
            font-size: 18px;
            color: #007bff;
        }

        /* Appointments and Telemedicine Sections */
        .appointments-section {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap; /* Allow sections to stack */
            margin-top: 30px;
        }

        .appointments, 
        .history {
            width: 48%; /* Default: Two side-by-side sections */
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .appointments h3, 
        .history h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        .appointment-item{
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }

        .history-item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #ff007b;
        }


        /* Calendar Styling */  
        #realTimeCalendarContainer {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        #realTimeCalendar {
            width: 600px; 
            /* max-width: 100%;  */
            height: auto;
            background-color: #fff;
            padding: 15px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); 
        }



        /* dashboard metrics section */
        .dashboard-metrics {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dashboard-metrics h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
        }

        .metrics-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .metric-item {
            flex: 1 1 calc(33.333% - 20px); /* Default: 3 items per row */
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border-left: 5px solid #007bff;
            text-align: center;
        }

        .metric-item h3 {
            font-size: 16px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .metric-item p, .summary-item p {
            font-size: 40px;
            color: #555;
            font-weight: bold;
        }

        /* For screens smaller than or equal to 767px, show the mobile logo */
        @media (max-width: 767px) {
            #desktop-logo {
                display: none;
            }
            #mobile-logo {
                display: block !important;
            }

            .metric-item {
                flex: 1 1 100%; /* Stacks into 3 rows on small screens */
            }

            .dashboard-summary {
                flex-direction: column; /* Stack summary items */
            }

            .summary-item {
                flex: 1 1 100%; /* Take full width for each item */
                margin-bottom: 15px;
            }

            .appointments, 
            .history {
                width: 100%; /* Stack sections on top of each other */
            }

            .action-buttons {
                flex-direction: column; /* Stack buttons vertically */
            }

            .navbar {
                margin-left: 60px !important; /* shift navbar to the right */
            }

            .sidebar.collapsed {
                width: 60px;
            }

            
            .content {
                margin-left: 60px !important;
            }

            .sidebar {
                width: 60px !important; /* collapse to 60px */
            }


            .sidebar-link::after {
                content: attr(data-title); /* Use the data-title attribute */
                position: absolute;
                left: 100%; /* Position to the right of the icon */
                top: 50%;
                transform: translateY(-50%);
                background-color: #333;
                color: #fff;
                padding: 5px 10px;
                border-radius: 4px;
                white-space: nowrap;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.2s ease, visibility 0.2s ease;
                z-index: 1000 !important;
            }

            /* Show the tooltip on hover */
            .sidebar-link:hover::after {
                opacity: 1;
                visibility: visible;
                z-index: 1000 !important;
            }
            

            .sidebar:not(.collapsed) .sidebar-text {
                display: inline-block;
            }

            .sidebar-text {
                display: none !important;
            }

            .sidebar.collapsed:hover .sidebar-text {
                display: none !important;
            }


            /* Adjust navbar content when collapsed */
            .navbar .container-fluid {
                display: flex;
                justify-content: space-between;
                width: 100%;
            }

            .navbar .d-flex {
                width: 100%; /* Allow space for content */
            }

            /* Adjust logout button */
            .navbar .d-flex justify-content-end {
                display: flex;
                justify-content: flex-end;
                flex-grow: 1;
            }

            /* Ensure logout button doesn't overflow */
            .btn-action {
                width: auto; /* Let the button take its natural width */
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

        <a href="{{ route('doctors.doctor-dashboard') }}" class="sidebar-link" data-title="Dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span class="sidebar-text">Dashboard</span>
        </a>
        <a href="{{ route('doctors.profile') }}" class="sidebar-link" data-title="Profile">
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
                <span class="fw-semibold me-3">Welcome, {{ Auth::guard('doctors')->user()->first_name }}</span>
                <form action="{{ route('doctors.logout') }}" method="POST" class="mb-0">
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
            // Check if the screen width is 768px or more (non-mobile)
            if (window.innerWidth >= 768) {
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
        }
    </script>

    @if(Route::currentRouteName() === 'doctors.doctor-dashboard') <!-- Check if the current route is the dashboard -->

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('realTimeCalendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth', // Month view
                    headerToolbar: {
                        left: 'prev,next today', // Navigation buttons
                        center: 'title',         // Title (month and year)
                        right: 'dayGridMonth,dayGridWeek', // View options
                    },
                    nowIndicator: true,         // Highlights the current time
                    selectable: true,          // Allow selecting days
                });

                calendar.render();
            });
        </script>
    @endif

</body>
</html>
