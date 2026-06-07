<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPERUM - Sistem Informasi Cluster')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-green: #2ecc71;
            --dark-green: #27ae60;
            --light-green: #d4edda;
            --soft-green: #e8f5e9;
            --accent-yellow: #f1c40f;
            --text-dark: #2c3e50;
            --text-light: #ecf0f1;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            min-height: 100vh;
            color: var(--text-dark);
        }
        
        /* Navbar Style */
        .navbar-custom {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(46, 204, 113, 0.3);
        }
        
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .navbar-custom .navbar-brand i {
            margin-right: 10px;
            animation: leafWave 2s infinite;
        }
        
        @keyframes leafWave {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(10deg); }
        }
        
        .navbar-custom .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            margin: 0 5px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .navbar-custom .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .navbar-custom .nav-link i {
            margin-right: 8px;
        }
        
        /* Card Style */
        .card-dashboard {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(46, 204, 113, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }
        
        .card-dashboard:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(46, 204, 113, 0.3);
        }
        
        .card-dashboard::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-yellow));
        }
        
        .card-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--light-green), var(--soft-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto;
        }
        
        .card-icon i {
            font-size: 2.5rem;
            color: var(--dark-green);
        }
        
        .card-title {
            color: var(--dark-green);
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        
        .card-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 5px;
        }
        
        .card-footer-info {
            background: var(--soft-green);
            padding: 15px;
            border-top: 2px dashed var(--primary-green);
        }
        
        /* Floating Shapes */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            background: rgba(46, 204, 113, 0.1);
            border-radius: 50%;
            animation: float 6s infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
            100% { transform: translateY(0px) rotate(360deg); }
        }
        
        /* Button Style */
        .btn-green {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-green:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(46, 204, 113, 0.4);
            color: white;
        }
        
        .btn-outline-green {
            border: 2px solid var(--primary-green);
            color: var(--dark-green);
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-green:hover {
            background: var(--primary-green);
            color: white;
        }
        
        /* Alert Style */
        .alert-success-custom {
            background: var(--light-green);
            border-left: 5px solid var(--dark-green);
            color: var(--dark-green);
            border-radius: 10px;
        }
        
        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.9), rgba(39, 174, 96, 0.9));
            border-radius: 30px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 15px 30px rgba(46, 204, 113, 0.3);
        }
        
        /* Table Style */
        .table-custom {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .table-custom thead {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
        }
        
        .table-custom th {
            padding: 15px;
            font-weight: 500;
        }
        
        .table-custom td {
            padding: 12px 15px;
            vertical-align: middle;
        }
        
        /* Badge */
        .badge-green {
            background: var(--light-green);
            color: var(--dark-green);
            padding: 5px 10px;
            border-radius: 50px;
            font-weight: 500;
        }
        
        /* Modal Style */
        .modal-content-custom {
            border-radius: 30px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .modal-header-custom {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
            border-radius: 30px 30px 0 0;
            padding: 20px;
        }
        
        /* Dropdown menu style */
        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
            padding: 8px 0;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: var(--soft-green);
            color: var(--dark-green);
        }
        
        .dropdown-item i {
            width: 20px;
            color: var(--primary-green);
        }
        
        .dropdown-item.text-danger:hover {
            background: #fee2e2;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Floating Shapes -->
    <div class="floating-shapes">
        <div class="shape" style="width: 150px; height: 150px; top: 10%; left: 5%;"></div>
        <div class="shape" style="width: 200px; height: 200px; top: 60%; right: 5%;"></div>
        <div class="shape" style="width: 100px; height: 100px; bottom: 20%; left: 10%;"></div>
        <div class="shape" style="width: 180px; height: 180px; top: 30%; right: 15%;"></div>
    </div>

   @if(!request()->routeIs('login') && !str_contains(request()->url(), 'reset-password'))
    <!-- Navbar (tidak tampil di halaman login) -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-leaf"></i>
                SIPERUM
                <small class="fs-6 opacity-75">| Sistem Informasi Cluster</small>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> 
                            {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('pengaturan') }}">
                                    <i class="fas fa-cog me-2"></i> Pengaturan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endif

    <!-- Main Content -->
    <main style="min-height: calc(100vh - 80px);">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
        
        // Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
    
    @stack('scripts')
</body>
</html>