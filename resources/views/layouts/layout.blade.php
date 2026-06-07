<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPERUM - Sistem Informasi Cluster')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --primary-green: #2ecc71;
            --dark-green: #27ae60;
            --light-green: #d4edda;
            --soft-green: #e8f5e9;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* ========== NAVBAR RESPONSIF ========== */
        .navbar-top {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            width: 100%;
        }
        
        /* ========== SIDEBAR RESPONSIF ========== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 60px;
            bottom: 0;
            width: 260px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            overflow-y: auto;
            z-index: 999;
            transition: transform 0.3s ease;
        }
        
        /* Tombol toggle sidebar untuk mobile */
        .sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            color: white;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.4);
        }
        
        /* ========== MAIN CONTENT RESPONSIF ========== */
        .main-content {
            margin-left: 260px;
            margin-top: 60px;
            padding: 20px;
            min-height: calc(100vh - 60px);
            transition: margin-left 0.3s ease;
        }
        
        /* ========== RESPONSIVE BREAKPOINTS ========== */
        
        /* Tablet (max-width: 992px) */
        @media (max-width: 992px) {
            .sidebar {
                width: 240px;
            }
            .main-content {
                margin-left: 240px;
            }
        }
        
        /* Mobile (max-width: 768px) */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                top: 56px;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
                margin-top: 56px;
            }
            
            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .navbar-top .container-fluid {
                padding: 0 15px;
            }
            
            .navbar-top h5 {
                font-size: 14px;
            }
            
            .navbar-top .text-muted {
                font-size: 12px;
            }
            
            .sidebar-menu a {
                padding: 10px 12px;
                font-size: 14px;
            }
            
            .sidebar-menu i {
                width: 25px;
                font-size: 14px;
            }
        }
        
        /* Mobile kecil (max-width: 576px) */
        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            
            .navbar-top h5 {
                font-size: 12px;
            }
            
            .navbar-top .fa-leaf {
                font-size: 20px;
            }
            
            .btn-green {
                padding: 6px 12px;
                font-size: 12px;
            }
            
            .table-responsive {
                font-size: 12px;
            }
            
            .btn-group .btn-sm {
                padding: 4px 8px;
                font-size: 10px;
            }
            
            .card-cluster .fw-bold {
                font-size: 14px;
            }
            
            h4.fw-bold {
                font-size: 18px;
            }
            
            .status-badge {
                padding: 3px 8px;
                font-size: 10px;
            }
            
            /* Stats cards mobile */
            .row.g-4 {
                --bs-gutter-y: 1rem;
            }
            
            .col-md-3 {
                margin-bottom: 10px;
            }
        }
        
        /* ========== STYLE KOMPONEN ========== */
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--soft-green);
            color: var(--dark-green);
        }
        
        .sidebar-menu i {
            width: 28px;
            margin-right: 8px;
            color: var(--primary-green);
            font-size: 16px;
        }
        
        .card-cluster {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card-cluster:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(46, 204, 113, 0.15);
        }
        
        .btn-green {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .btn-green:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
            color: white;
        }
        
        .btn-outline-green {
            border: 2px solid var(--primary-green);
            color: var(--dark-green);
            background: transparent;
            border-radius: 8px;
            padding: 6px 16px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-green:hover {
            background: var(--primary-green);
            color: white;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }
        
        .status-aktif {
            background: var(--soft-green);
            color: var(--dark-green);
        }
        
        .status-nonaktif {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status-draft {
            background: #fff3cd;
            color: #856404;
        }
        
        .table-cluster th {
            background: var(--soft-green);
            color: var(--dark-green);
            font-weight: 600;
            font-size: 13px;
        }
        
        .table-cluster td {
            font-size: 13px;
            vertical-align: middle;
        }
        
        /* Table responsive wrapper */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .gambar-thumbnail {
            width: 60px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .progress-bar-custom {
            height: 6px;
            border-radius: 4px;
            background: var(--light-green);
        }
        
        .progress-bar-custom .progress-bar {
            background: var(--primary-green);
            border-radius: 4px;
        }
        
        /* Alert responsive */
        .alert {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
        }
        
        /* Pagination responsive */
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .pagination .page-link {
            padding: 6px 12px;
            font-size: 13px;
        }
        
        /* Modal responsive */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 10px;
            }
            
            .modal-body {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Tombol Toggle Sidebar untuk Mobile -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Navbar Top -->
    <nav class="navbar-top">
        <div class="container-fluid px-3 px-md-4">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="d-flex align-items-center">
                    <i class="fas fa-leaf fa-2x text-success me-2 me-md-3"></i>
                    <h5 class="mb-0 fw-bold" style="font-size: clamp(14px, 4vw, 20px);">SIPERUM - Sistem Informasi Cluster</h5>
                </div>
                <div class="d-flex align-items-center gap-2 gap-md-3">
                    <span class="text-muted" style="font-size: clamp(11px, 3vw, 14px);">
                        <i class="fas fa-user me-1 me-md-2"></i>
                        <span class="d-none d-sm-inline">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                        <span class="d-inline d-sm-none">{{ substr(Auth::guard('admin')->user()->name ?? 'Admin', 0, 10) }}...</span>
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm" style="padding: 5px 10px;">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="d-none d-md-inline ms-1">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" 
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>

            <!-- Cluster -->
            <li>
                <a href="{{ route('cluster.index') }}" 
                class="{{ request()->routeIs('cluster.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> <span>Cluster</span>
                </a>
            </li>

            <!-- Tipe Rumah -->
            <li>
                <a href="{{ route('tipe-rumah.index') }}" 
                class="{{ request()->routeIs('tipe-rumah.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> <span>Tipe Rumah</span>
                </a>
            </li>

            <!-- Berita -->
            <li>
                <a href="{{ route('berita.index') }}" 
                class="{{ request()->routeIs('berita.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i> <span>Berita</span>
                </a>
            </li>

            <!-- Galeri -->
            <li>
                <a href="{{ route('galeri.index') }}" 
                class="{{ request()->routeIs('galeri.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i> <span>Galeri</span>
                </a>
            </li>

            <!-- Kontak -->
            <li>
                <a href="{{ route('kontak.index') }}" 
                class="{{ request()->routeIs('kontak.*') ? 'active' : '' }}">
                    <i class="fas fa-address-book"></i> <span>Kontak</span>
                </a>
            </li>

            <!-- Pesan -->
            <li>
                <a href="{{ route('message.index') }}" 
                class="{{ request()->routeIs('message.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> <span>Pesan</span>
                </a>
            </li>

            <!-- Manajemen Halaman -->
            <li>
                <a href="{{ route('pages.index') }}" 
                class="{{ request()->routeIs('pages.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> <span>Manajemen Halaman</span>
                </a>
            </li>

            <!-- Struktur Organisasi -->
            <li>
                <a href="{{ route('team.index') }}" 
                class="{{ request()->routeIs('team.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>Struktur Organisasi</span>
                </a>
            </li>

            <!-- Separator -->
            <li class="mt-4 pt-3 border-top"></li>

            <!-- Pengaturan -->
            <li>
                <a href="{{ route('pengaturan') }}" 
                class="{{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });
        
        // Toggle sidebar untuk mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });
        }
        
        // Tutup sidebar saat klik di luar (mobile)
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
        
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
        
        // Fix untuk tabel responsive
        $('.table-responsive').each(function() {
            if ($(this).find('table').length) {
                $(this).css('overflow-x', 'auto');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>