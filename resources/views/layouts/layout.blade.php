<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Manajemen Galeri - SIPERUM')</title>
    
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
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }
        
        .navbar-top {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            bottom: 0;
            width: 250px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            overflow-y: auto;
            z-index: 999;
        }
        
        .main-content {
            margin-left: 250px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
        }
        
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
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--soft-green);
            color: var(--dark-green);
        }
        
        .sidebar-menu i {
            width: 25px;
            color: var(--primary-green);
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
        }
        
        .btn-green:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
            color: white;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
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
        }
        
        .gambar-thumbnail {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .progress-bar-custom {
            height: 8px;
            border-radius: 4px;
            background: var(--light-green);
        }
        
        .progress-bar-custom .progress-bar {
            background: var(--primary-green);
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Navbar Top -->
    <nav class="navbar-top">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-leaf fa-2x text-success me-3"></i>
                    <h5 class="mb-0 fw-bold">SIPERUM - Sistem Informasi Cluster</h5>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted">
                        <i class="fas fa-user me-2"></i>
                        {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" 
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>

            <!-- Cluster -->
            <li>
                <a href="{{ route('cluster.index') }}" 
                class="{{ request()->routeIs('cluster.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> Cluster
                </a>
            </li>

            <!-- Tipe Rumah -->
            <li>
                <a href="{{ route('tipe-rumah.index') }}" 
                class="{{ request()->routeIs('tipe-rumah.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Tipe Rumah
                </a>
            </li>

            <!-- Berita -->
            <li>
                <a href="{{ route('berita.index') }}" 
                class="{{ request()->routeIs('berita.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i> Berita
                </a>
            </li>

            <!-- Galeri -->
            <li>
                <a href="{{ route('galeri.index') }}" 
                class="{{ request()->routeIs('galeri.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i> Galeri
                </a>
            </li>

            <!-- Kontak -->
            <li>
                <a href="{{ route('kontak.index') }}" 
                class="{{ request()->routeIs('kontak.*') ? 'active' : '' }}">
                    <i class="fas fa-address-book"></i> Kontak
                </a>
            </li>

            <!-- Pesan -->
            <li>
                <a href="{{ route('message.index') }}" 
                class="{{ request()->routeIs('message.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Pesan
                </a>
            </li>

            <!-- Manajemen Halaman (Pages) - BARU -->
            <li>
                <a href="{{ route('pages.index') }}" 
                class="{{ request()->routeIs('pages.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Manajemen Halaman
                </a>
            </li>

            <li>
                <a href="{{ route('team.index') }}" 
                class="{{ request()->routeIs('team.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Struktur Organisasi
                </a>
            </li>

            <!-- Separator -->
            <li class="mt-4 pt-3 border-top"></li>

            <!-- Pengaturan -->
            <li>
                <a href="{{ route('pengaturan') }}" 
                class="{{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
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
    </script>
    
    @stack('scripts')
</body>
</html>