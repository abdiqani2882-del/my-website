<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portfolio & Doc Manager')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        // Inline script to prevent theme flash (FOUC)
        (function() {
            const savedTheme = localStorage.getItem('portfolio-theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
    
    <style>
        :root {
            --primary-color: #2563EB;
            --primary-hover: #1D4ED8;
            --bg-color: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --sidebar-bg: #FFFFFF;
            --sidebar-color: #0F172A;
            --sidebar-hover: #F1F5F9;
            --sidebar-active-bg: #EFF6FF;
            --sidebar-active-color: #2563EB;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.03);
        }

        .dark-mode {
            --bg-color: #0F172A;
            --card-bg: #1E293B;
            --text-main: #F8FAFC;
            --text-muted: #94A3B8;
            --border-color: #334155;
            --sidebar-bg: #1E293B;
            --sidebar-color: #E2E8F0;
            --sidebar-hover: #334155;
            --sidebar-active-bg: #2563EB;
            --sidebar-active-color: #FFFFFF;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.2);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.2), 0 2px 4px -1px rgba(0,0,0,0.15);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.25), 0 4px 6px -2px rgba(0,0,0,0.15);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        #sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }
        
        .sidebar-brand {
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.25rem;
        }
        
        .sidebar-brand i {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .sidebar-menu {
            padding: 20px 0;
            list-style: none;
            margin: 0;
        }

        .sidebar-item a {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: var(--sidebar-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            margin-bottom: 4px;
        }

        .sidebar-item a:hover {
            background-color: var(--sidebar-hover);
            color: var(--text-main);
        }

        .sidebar-item.active a {
            background-color: var(--sidebar-active-bg);
            color: var(--sidebar-active-color);
            border-left-color: var(--primary-color);
            font-weight: 600;
        }

        .sidebar-item a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content wrapper */
        #main-wrapper {
            margin-left: 260px;
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .top-navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: var(--shadow-sm);
        }

        .search-box {
            position: relative;
            max-width: 320px;
            width: 100%;
        }

        .search-box input {
            border: 1px solid var(--border-color);
            background-color: var(--bg-color);
            color: var(--text-main);
            padding: 8px 16px 8px 40px;
            border-radius: 50px;
            width: 100%;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            background-color: var(--card-bg);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .datetime-display {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .user-nav-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            text-decoration: none;
            color: var(--text-main);
        }

        .user-nav-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .content-body {
            padding: 30px;
            flex: 1;
        }

        /* Elements & Components styling */
        .card-custom {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .card-custom:hover {
            box-shadow: var(--shadow-md);
        }

        .table-custom {
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
        }

        .table-custom th {
            color: var(--text-muted);
            background-color: var(--bg-color);
            font-weight: 600;
        }

        /* Theme button styling */
        .theme-toggle-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.25rem;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .theme-toggle-btn:hover {
            color: var(--primary-color);
        }

        /* Mobile Adjustments */
        .sidebar-toggle-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 991.98px) {
            #sidebar {
                left: -260px;
            }
            #sidebar.active {
                left: 0;
            }
            #main-wrapper {
                margin-left: 0;
            }
            .sidebar-toggle-btn {
                display: block;
            }
            .datetime-display {
                display: none;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

<!-- Sidebar -->
<aside id="sidebar">
    <div class="sidebar-brand">
        <i class="fa-solid fa-briefcase"></i>
        <span>Portfolio Manager</span>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('profile.*') ? 'active' : '' }}">
            <a href="{{ route('profile.index') }}">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('certificates.*') ? 'active' : '' }}">
            <a href="{{ route('certificates.index') }}">
                <i class="fa-solid fa-award"></i>
                <span>Certificates</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('education.*') ? 'active' : '' }}">
            <a href="{{ route('education.index') }}">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Education</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('work-experiences.*') ? 'active' : '' }}">
            <a href="{{ route('work-experiences.index') }}">
                <i class="fa-solid fa-briefcase"></i>
                <span>Work Experience</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('skills.*') ? 'active' : '' }}">
            <a href="{{ route('skills.index') }}">
                <i class="fa-solid fa-sliders"></i>
                <span>Skills</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('photos.*') ? 'active' : '' }}">
            <a href="{{ route('photos.index') }}">
                <i class="fa-solid fa-images"></i>
                <span>Photos</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('documents.*') ? 'active' : '' }}">
            <a href="{{ route('documents.index') }}">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Documents</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('settings.*') ? 'active' : '' }}">
            <a href="{{ route('settings.index') }}">
                <i class="fa-solid fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
        <li class="sidebar-item mt-4">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</aside>

<!-- Main Wrapper -->
<div id="main-wrapper">
    <!-- Navbar -->
    <header class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle-btn" id="sidebar-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
            <form action="{{ route('search') }}" method="GET" class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="query" placeholder="Global search..." value="{{ request('query') }}">
            </form>
        </div>
        
        <div class="nav-right">
            <div class="datetime-display" id="live-time">
                <!-- Javascript will render dynamic clock here -->
            </div>
            
            <button class="theme-toggle-btn" id="theme-toggle">
                <i class="fa-solid fa-moon"></i>
            </button>
            
            <div class="dropdown">
                <a href="#" class="user-nav-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    @php
                        $profilePhoto = Auth::user()->profile?->profile_photo;
                        $avatarUrl = $profilePhoto ? asset('storage/' . $profilePhoto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=2563EB&color=ffffff';
                    @endphp
                    <img src="{{ $avatarUrl }}" alt="Avatar" class="user-nav-avatar">
                    <span class="d-none d-md-inline fw-semibold small">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 8px;">
                    <li><a class="dropdown-item py-2" href="{{ route('profile.index') }}"><i class="fa-solid fa-user me-2 text-muted"></i> Profile</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('settings.index') }}"><i class="fa-solid fa-cog me-2 text-muted"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="content-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" style="border-left: 4px solid #10B981 !important; border-radius: 8px; background-color: var(--card-bg); color: var(--text-main);" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-check text-success fs-4 me-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" style="border-left: 4px solid #EF4444 !important; border-radius: 8px; background-color: var(--card-bg); color: var(--text-main);" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-xmark text-danger fs-4 me-3"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" style="border-left: 4px solid #EF4444 !important; border-radius: 8px; background-color: var(--card-bg); color: var(--text-main);" role="alert">
                <div class="d-flex">
                    <i class="fa-solid fa-triangle-exclamation text-danger fs-4 me-3 mt-1"></i>
                    <div>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Sidebar Mobile Toggle
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    // Close sidebar if clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 992) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        }
    });

    // Theme Switcher Logic
    const themeToggle = document.getElementById('theme-toggle');
    const root = document.documentElement;

    function updateThemeIcon(theme) {
        const icon = themeToggle.querySelector('i');
        if (theme === 'dark') {
            icon.className = 'fa-solid fa-sun text-warning';
        } else {
            icon.className = 'fa-solid fa-moon';
        }
    }

    // Set initial theme icon
    const currentTheme = localStorage.getItem('portfolio-theme') || 'light';
    updateThemeIcon(currentTheme);

    themeToggle.addEventListener('click', () => {
        const isDark = root.classList.contains('dark-mode');
        if (isDark) {
            root.classList.remove('dark-mode');
            localStorage.setItem('portfolio-theme', 'light');
            updateThemeIcon('light');
        } else {
            root.classList.add('dark-mode');
            localStorage.setItem('portfolio-theme', 'dark');
            updateThemeIcon('dark');
        }
        
        // Also save this via AJAX (optional) to save state on server settings
        fetch("{{ route('settings.theme') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ theme: isDark ? 'light' : 'dark' })
        }).catch(err => console.log('Theme sync error: ', err));
    });

    // Live Clock Logic
    function updateClock() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: true 
        };
        const formatter = new Intl.DateTimeFormat('en-US', options);
        document.getElementById('live-time').innerHTML = `<i class="fa-regular fa-clock me-2"></i> ${formatter.format(now)}`;
    }
    
    updateClock();
    setInterval(updateClock, 1000);
</script>
@yield('scripts')
</body>
</html>
