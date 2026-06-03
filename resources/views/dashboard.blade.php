@extends('layouts.app')

@section('title', 'Dashboard SIPERUM')

@section('content')
<style>
    /* Sticky Header */
    .navbar-top {
        position: sticky !important;
        top: 0;
        z-index: 1030;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    /* Scroll to Top Button */
    .scroll-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
        z-index: 999;
        box-shadow: 0 4px 12px rgba(46, 204, 113, 0.3);
    }
    
    .scroll-to-top.show {
        opacity: 1;
        visibility: visible;
    }
    
    .scroll-to-top:hover {
        transform: translateY(-5px);
        background: linear-gradient(135deg, #27ae60, #219653);
        box-shadow: 0 6px 16px rgba(46, 204, 113, 0.4);
    }
    
    .scroll-to-top i {
        font-size: 1.2rem;
    }
    
    /* Tanggal style */
    .date-badge {
        font-size: 1rem !important;
        padding: 10px 20px !important;
    }
    
    /* Card dashboard */
    .card-dashboard {
        background: white;
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .card-dashboard:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(46, 204, 113, 0.15);
    }
    
    .card-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #e8f5e9, #d4edda);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }
    
    .card-icon i {
        font-size: 2rem;
        color: #27ae60;
    }
    
    .card-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: #27ae60;
        margin-bottom: 5px;
    }
    
    .card-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    
    .badge-green {
        background: #e8f5e9;
        color: #27ae60;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
    }
    
    .btn-outline-green {
        border: 2px solid #2ecc71;
        color: #27ae60;
        border-radius: 8px;
        padding: 8px 0;
        transition: all 0.3s ease;
    }
    
    .btn-outline-green:hover {
        background: #2ecc71;
        color: white;
    }
    
    .card-footer-info {
        background: #f8f9fa;
        padding: 12px;
        border-top: 1px solid #e9ecef;
    }
    
    .welcome-section {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        color: white;
    }
    
    /* Activity Timeline */
    .activity-timeline {
        max-height: 500px;
        overflow-y: auto;
    }
    
    .activity-item {
        transition: all 0.2s ease;
        padding: 12px;
        border-radius: 10px;
    }
    
    .activity-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
    }
    
    /* Logout button style */
    .btn-light.text-danger {
        border: 1px solid rgba(220, 53, 69, 0.2);
        transition: all 0.3s ease;
    }
    
    .btn-light.text-danger:hover {
        background-color: #dc3545 !important;
        color: white !important;
        border-color: #dc3545;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }
    
    .btn-light.text-danger:hover i {
        color: white !important;
    }
    
    /* Modal animation */
    .modal.fade .modal-dialog {
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }
    
    .modal.show .modal-dialog {
        transform: scale(1);
    }
</style>

<div class="container py-4">
    <!-- Welcome Section -->
    <div class="welcome-section" data-aos="fade-down">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold">
                    <i class="fas fa-hand-wave me-2"></i>
                    Halo, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}!
                </h2>
                <p class="mb-0 opacity-75">
                    Selamat datang di dashboard SIPERUM. Mari kelola data cluster dengan mudah dan efisien.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="d-flex justify-content-md-end gap-2">
                    <span class="badge bg-white text-success p-3 rounded-pill date-badge">
                        <i class="fas fa-calendar me-2"></i>
                        {{ now()->format('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Card - Total Cluster -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card-dashboard text-center p-3">
                <div class="card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3 class="card-number">{{ $totalCluster ?? 0 }}</h3>
                <p class="card-title">Total Cluster</p>
                <div class="mt-2">
                    <span class="badge-green">
                        <i class="fas fa-arrow-up me-1"></i>+{{ $clusterBaru ?? 0 }} bulan ini
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Menu Cards -->
    <h4 class="fw-bold mb-4" style="color: #27ae60;" data-aos="fade-right">
        <i class="fas fa-th-large me-2"></i>Menu Utama
    </h4>
    
    <div class="row g-4">
        <!-- Cluster Card -->
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="card-dashboard">
                <div class="card-body text-center p-4">
                    <div class="card-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h5 class="card-title">Data Cluster</h5>
                    <p class="text-muted small">Kelola data cluster, lokasi, dan fasilitas</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-light text-success">{{ $totalCluster ?? 0 }} Cluster</span>
                        <span class="badge bg-light text-success">{{ $totalUnit ?? 0 }} Unit</span>
                    </div>
                    <a href="{{ route('cluster.index') }}" class="btn btn-outline-green w-100">
                        <i class="fas fa-edit me-2"></i>Kelola Cluster
                    </a>
                </div>
                <div class="card-footer-info text-center">
                    <small>
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $clusterBaru ?? 0 }} cluster baru bulan ini
                    </small>
                </div>
            </div>
        </div>

        <!-- Tipe Rumah Card -->
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="card-dashboard">
                <div class="card-body text-center p-4">
                    <div class="card-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h5 class="card-title">Tipe Rumah</h5>
                    <p class="text-muted small">Atur tipe rumah, spesifikasi, dan harga</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-light text-success">{{ $totalTipeRumah ?? 0 }} Tipe</span>
                        <span class="badge bg-light text-success">{{ $tipeRumahBaru ?? 0 }} New</span>
                    </div>
                    <a href="{{ route('tipe-rumah.index') }}" class="btn btn-outline-green w-100">
                        <i class="fas fa-layer-group me-2"></i>Kelola Tipe
                    </a>
                </div>
                <div class="card-footer-info text-center">
                    <small>
                        <i class="fas fa-home me-1"></i>
                        Tipe {{ $tipeTersedia ?? '36/60/72' }} tersedia
                    </small>
                </div>
            </div>
        </div>

        <!-- Berita Card -->
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="card-dashboard">
                <div class="card-body text-center p-4">
                    <div class="card-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h5 class="card-title">Berita & Artikel</h5>
                    <p class="text-muted small">Publikasi berita terbaru seputar cluster</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-light text-success">{{ $totalBerita ?? 0 }} Berita</span>
                        <span class="badge bg-light text-success">{{ $totalDraft ?? 0 }} Draft</span>
                    </div>
                    <a href="{{ route('berita.index') }}" class="btn btn-outline-green w-100">
                        <i class="fas fa-pen me-2"></i>Kelola Berita
                    </a>
                </div>
                <div class="card-footer-info text-center">
                    <small>
                        <i class="fas fa-clock me-1"></i>
                        {{ $beritaPerluReview ?? 0 }} berita perlu review
                    </small>
                </div>
            </div>
        </div>

        <!-- Galeri Card -->
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="400">
            <div class="card-dashboard">
                <div class="card-body text-center p-4">
                    <div class="card-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <h5 class="card-title">Galeri</h5>
                    <p class="text-muted small">Kelola foto-foto cluster dan lingkungan</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-light text-success">{{ $totalFoto ?? 0 }} Foto</span>
                        <span class="badge bg-light text-success">{{ $totalAlbum ?? 0 }} Album</span>
                    </div>
                    <a href="{{ route('galeri.index') }}" class="btn btn-outline-green w-100">
                        <i class="fas fa-camera me-2"></i>Kelola Galeri
                    </a>
                </div>
                <div class="card-footer-info text-center">
                    <small>
                        <i class="fas fa-cloud-upload-alt me-1"></i>
                        {{ $fotoPending ?? 0 }} foto pending
                    </small>
                </div>
            </div>
        </div>

        <!-- Kontak Card -->
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="500">
            <div class="card-dashboard">
                <div class="card-body text-center p-4">
                    <div class="card-icon">
                        <i class="fas fa-address-book"></i>
                    </div>
                    <h5 class="card-title">Kontak</h5>
                    <p class="text-muted small">Data kontak customer dan prospek</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-light text-success">{{ $totalKontak ?? 0 }} Kontak</span>
                        <span class="badge bg-light text-success">{{ $kontakHot ?? 0 }} Hot</span>
                    </div>
                    <a href="{{ route('kontak.index') }}" class="btn btn-outline-green w-100">
                        <i class="fas fa-phone me-2"></i>Kelola Kontak
                    </a>
                </div>
                <div class="card-footer-info text-center">
                    <small>
                        <i class="fas fa-clock me-1"></i>
                        {{ $followUpHariIni ?? 0 }} follow-up hari ini
                    </small>
                </div>
            </div>
        </div>

        <!-- Pesan Card -->
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="600">
            <div class="card-dashboard">
                <div class="card-body text-center p-4">
                    <div class="card-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5 class="card-title">Pesan Masuk</h5>
                    <p class="text-muted small">Kelola pesan dari pengunjung website</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-light text-success">{{ $totalPesan ?? 0 }} Pesan</span>
                        <span class="badge bg-light text-danger">{{ $pesanUnread ?? 0 }} Unread</span>
                    </div>
                    <a href="{{ route('message.index') }}" class="btn btn-outline-green w-100">
                        <i class="fas fa-inbox me-2"></i>Lihat Pesan
                    </a>
                </div>
                <div class="card-footer-info text-center">
                    <small>
                        <i class="fas fa-circle text-danger me-1"></i>
                        {{ $pesanUnread ?? 0 }} pesan belum dibaca
                    </small>
                </div>
            </div>
        </div>

        <!-- Pages Card -->
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="700">
            <div class="card-dashboard">
                <div class="card-body text-center p-4">
                    <div class="card-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h5 class="card-title">Manajemen Halaman</h5>
                    <p class="text-muted small">Kelola halaman statis website (Tentang Kami, Kontak, dll)</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-light text-success">{{ $totalPages ?? 0 }} Halaman</span>
                        <span class="badge bg-light text-success">{{ $publishedPages ?? 0 }} Publikasi</span>
                    </div>
                    <a href="{{ route('pages.index') }}" class="btn btn-outline-green w-100">
                        <i class="fas fa-edit me-2"></i>Kelola Halaman
                    </a>
                </div>
                <div class="card-footer-info text-center">
                    <small>
                        <i class="fas fa-globe me-1"></i>
                        Halaman {{ $latestPage ?? 'Tentang Kami' }} terakhir diperbarui
                    </small>
                </div>
            </div>
        </div>

        <!-- Struktur Organisasi Card -->
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="800">
            <div class="card-dashboard">
                <div class="card-body text-center p-4">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="card-title">Struktur Organisasi</h5>
                    <p class="text-muted small">Kelola owner, direktur, dan tim perusahaan</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-light text-success">{{ $totalTeam ?? 0 }} Anggota</span>
                        <span class="badge bg-light text-success">{{ $totalTeamAktif ?? 0 }} Aktif</span>
                    </div>
                    <a href="{{ route('team.index') }}" class="btn btn-outline-green w-100">
                        <i class="fas fa-users me-2"></i>Kelola Tim
                    </a>
                </div>
                <div class="card-footer-info text-center">
                    <small>
                        <i class="fas fa-user-tie me-1"></i>
                        Founder & CEO, Direktur, dll.
                    </small>
                </div>
            </div>
        </div>
    </div> <!-- PENUTUP ROW -->

    <!-- Aktivitas Terbaru -->
    <div class="row mt-5">
        <div class="col-md-12" data-aos="fade-up">
            <div class="card-dashboard p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0" style="color: #27ae60;">
                        <i class="fas fa-history me-2"></i>Aktivitas Terbaru
                    </h5>
                    <a href="#" class="text-success" id="refreshActivities">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </a>
                </div>
                
                <div class="activity-timeline" id="activityList">
                    @forelse($activities ?? [] as $activity)
                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom activity-item">
                        <div class="me-3">
                            <span class="badge-green p-2 rounded-circle">
                                <i class="fas fa-{{ $activity['icon'] }}"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-bold">{{ $activity['text'] }}</p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>{{ $activity['time'] }} 
                                | oleh {{ $activity['user'] }}
                            </small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada aktivitas</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scroll to Top Button -->
<div class="scroll-to-top" id="scrollToTop">
    <i class="fas fa-arrow-up"></i>
</div>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 rounded-circle p-4">
                        <i class="fas fa-sign-out-alt fa-4x text-danger"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-3">Yakin ingin logout?</h5>
                <p class="text-muted mb-4">Anda akan keluar dari dashboard SIPERUM</p>
                
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-light px-4 py-2" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4 py-2">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Scroll to Top Button
    const scrollToTopBtn = document.getElementById('scrollToTop');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    });
    
    scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Refresh Activities
    document.getElementById('refreshActivities')?.addEventListener('click', function(e) {
        e.preventDefault();
        const activityList = document.getElementById('activityList');
        activityList.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-success"></i><p class="text-muted mt-2">Memuat aktivitas...</p></div>';
        
        setTimeout(() => {
            location.reload();
        }, 1000);
    });
</script>
@endsection