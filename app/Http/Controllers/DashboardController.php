<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cluster;
use App\Models\TipeRumah;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Kontak;
use App\Models\Message;
use App\Models\Page;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Proteksi login
        if (!Auth::guard('admin')->check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // === STATS CARD ATAS ===
        
        // Total Cluster
        $totalCluster = Cluster::count();
        $clusterBaru = Cluster::whereMonth('created_at', now()->month)->count();
        
        // Total Unit Rumah
        $totalUnit = Cluster::sum('total_unit');
        $unitTerjualBulanIni = TipeRumah::whereMonth('updated_at', now()->month)->sum('unit_terjual');
        
        // Total Penghuni (asumsi dari unit terjual)
        $totalPenghuni = Cluster::sum('unit_terjual');
        $penghuniBaru = TipeRumah::whereMonth('updated_at', now()->month)->sum('unit_terjual');
        
        // Total Pendapatan (asumsi dari harga tipe rumah * unit terjual)
        $totalPendapatan = TipeRumah::sum(DB::raw('harga * unit_terjual'));
        $pendapatanBulanIni = TipeRumah::whereMonth('updated_at', now()->month)->sum(DB::raw('harga * unit_terjual'));

        // Total Team
        $totalTeam = DB::table('team')->count();
        $totalTeamAktif = DB::table('team')->where('status', 'aktif')->count();
        
        // === MENU CARD ===
        
        // Total Cluster (diambil dari jumlah cluster yang memiliki tipe rumah lebih dari 1)
        $totalClusterCount = TipeRumah::select('cluster_id')
            ->groupBy('cluster_id')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();
        
        if ($totalClusterCount == 0) {
            $totalClusterCount = 6;
        }
        
        // Total Tipe Rumah
        $totalTipeRumah = TipeRumah::count();
        $tipeRumahBaru = TipeRumah::whereMonth('created_at', now()->month)->count();
        
        // Ambil daftar tipe yang tersedia (nama tipe yang unik)
        $tipeTersediaArray = TipeRumah::distinct('nama_tipe')->pluck('nama_tipe')->toArray();
        $tipeTersedia = implode(', ', array_slice($tipeTersediaArray, 0, 4));
        if (empty($tipeTersedia)) {
            $tipeTersedia = '36, 45, 60, 72';
        }
        
        // Berita
        $totalBerita = Berita::count();
        $totalDraft = Berita::where('status', 'draft')->count();
        $beritaPerluReview = Berita::where('status', 'draft')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        
        // Galeri
        $totalFoto = Galeri::count();
        $totalAlbum = Galeri::distinct('kategori')->count();
        $fotoPending = Galeri::where('status', 'nonaktif')->count();
        
        // Kontak
        $totalKontak = Kontak::count();
        $kontakHot = Kontak::whereDate('created_at', now())->count();
        $followUpHariIni = Kontak::whereDate('created_at', now())->count();
        
        // Pesan
        $totalPesan = Message::count();
        $pesanUnread = Message::where('status', 'belum_dibaca')->count();

        // === PAGES (Manajemen Halaman) ===
        $totalPages = Page::count();
        $publishedPages = Page::where('status', 'published')->count();
        $latestPage = Page::orderBy('updated_at', 'desc')->value('title');

        // === STRUKTUR ORGANISASI (TEAM) ===
        $totalTeam = DB::table('team')->count();
        $totalTeamAktif = DB::table('team')->where('status', 'aktif')->count();
        $totalTeamNonaktif = DB::table('team')->where('status', 'nonaktif')->count();

        // === STATISTIK PERSENTASE ===
        
        $totalClusterAktif = Cluster::where('status', 'aktif')->count();
        $persentaseClusterAktif = $totalCluster > 0 ? round(($totalClusterAktif / $totalCluster) * 100) : 0;
        
        $totalUnitTerjual = Cluster::sum('unit_terjual');
        $persentaseUnitTerjual = $totalUnit > 0 ? round(($totalUnitTerjual / $totalUnit) * 100) : 0;
        
        $persentaseHunian = $totalUnit > 0 ? round(($totalUnitTerjual / $totalUnit) * 100) : 0;
        
        $totalBeritaPublished = Berita::where('status', 'published')->count();
        $persentaseBeritaPublished = $totalBerita > 0 ? round(($totalBeritaPublished / $totalBerita) * 100) : 0;
        
        // === STATISTIK CEPAT ===
        $prospekBaru = Kontak::whereMonth('created_at', now()->month)->count();
        $dealClosing = TipeRumah::whereMonth('updated_at', now()->month)->sum('unit_terjual');
        $kunjunganHariIni = Message::whereDate('created_at', now())->count();
        
        // === AKTIVITAS TERBARU ===
        $activities = collect();
        
        // Aktivitas dari Cluster
        $clusterActivities = Cluster::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->filter(function($item) {
                return !is_null($item->created_at);
            })
            ->map(function($item) {
                // Decode fasilitas untuk ditampilkan (opsional)
                $fasilitasCount = 0;
                if (!empty($item->fasilitas)) {
                    $fasilitasRaw = $item->fasilitas;
                    while (is_string($fasilitasRaw)) {
                        $decoded = json_decode($fasilitasRaw, true);
                        if ($decoded === null) break;
                        $fasilitasRaw = $decoded;
                    }
                    $fasilitasCount = is_array($fasilitasRaw) ? count($fasilitasRaw) : 0;
                }
                
                return [
                    'icon' => 'plus-circle',
                    'text' => 'Cluster "' . $item->nama_cluster . '" ditambahkan' . ($fasilitasCount > 0 ? ' dengan ' . $fasilitasCount . ' fasilitas' : ''),
                    'time' => $item->created_at->diffForHumans(),
                    'user' => 'Admin',
                    'created_at' => $item->created_at
                ];
            });
        
        // Aktivitas dari Tipe Rumah
        $tipeActivities = TipeRumah::with('cluster')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->filter(function($item) {
                return !is_null($item->created_at);
            })
            ->map(function($item) {
                return [
                    'icon' => 'tag',
                    'text' => 'Tipe rumah "' . $item->nama_tipe . '" ditambahkan di ' . ($item->cluster->nama_cluster ?? 'cluster'),
                    'time' => $item->created_at->diffForHumans(),
                    'user' => 'Admin',
                    'created_at' => $item->created_at
                ];
            });
        
        // Aktivitas dari Berita
        $beritaActivities = Berita::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->filter(function($item) {
                return !is_null($item->created_at);
            })
            ->map(function($item) {
                $status = $item->status == 'published' ? 'dipublikasikan' : 'disimpan sebagai draft';
                return [
                    'icon' => 'newspaper',
                    'text' => 'Berita "' . $item->judul . '" ' . $status,
                    'time' => $item->created_at->diffForHumans(),
                    'user' => $item->penulis ?? 'Admin',
                    'created_at' => $item->created_at
                ];
            });
        
        // Aktivitas dari Galeri
        $galeriActivities = Galeri::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->filter(function($item) {
                return !is_null($item->created_at);
            })
            ->map(function($item) {
                return [
                    'icon' => 'image',
                    'text' => 'Foto "' . ($item->judul_galeri ?? 'Galeri') . '" ditambahkan ke galeri',
                    'time' => $item->created_at->diffForHumans(),
                    'user' => 'Admin',
                    'created_at' => $item->created_at
                ];
            });
        
        // Aktivitas dari Kontak
        $kontakActivities = Kontak::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->filter(function($item) {
                return !is_null($item->created_at);
            })
            ->map(function($item) {
                return [
                    'icon' => 'address-book',
                    'text' => 'Kontak baru: ' . $item->nama . ($item->perusahaan ? ' (' . $item->perusahaan . ')' : ''),
                    'time' => $item->created_at->diffForHumans(),
                    'user' => 'System',
                    'created_at' => $item->created_at
                ];
            });
        
        // Aktivitas dari Message
        $messageActivities = Message::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->filter(function($item) {
                return !is_null($item->created_at);
            })
            ->map(function($item) {
                return [
                    'icon' => 'envelope',
                    'text' => 'Pesan baru dari ' . $item->nama . ' - Subjek: ' . $item->subjek,
                    'time' => $item->created_at->diffForHumans(),
                    'user' => 'System',
                    'created_at' => $item->created_at
                ];
            });
        
        // Aktivitas dari Pages
        $pagesActivities = Page::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->filter(function($item) {
                return !is_null($item->created_at);
            })
            ->map(function($item) {
                return [
                    'icon' => 'file-alt',
                    'text' => 'Halaman "' . $item->title . '" ' . ($item->status == 'published' ? 'dipublikasikan' : 'disimpan sebagai draft'),
                    'time' => $item->created_at->diffForHumans(),
                    'user' => 'Admin',
                    'created_at' => $item->created_at
                ];
            });
        
        // Gabungkan semua aktivitas
        $activities = $clusterActivities
            ->concat($tipeActivities)
            ->concat($beritaActivities)
            ->concat($galeriActivities)
            ->concat($kontakActivities)
            ->concat($messageActivities)
            ->concat($pagesActivities)
            ->sortByDesc('created_at')
            ->take(10);
        
        return view('dashboard', compact(
            // Stats Card
            'totalCluster', 'clusterBaru',
            'totalUnit', 'unitTerjualBulanIni',
            'totalPenghuni', 'penghuniBaru',
            'totalPendapatan', 'pendapatanBulanIni',
            // Menu Card
            'totalClusterCount',
            'totalTipeRumah', 'tipeRumahBaru', 'tipeTersedia',
            'totalBerita', 'totalDraft', 'beritaPerluReview',
            'totalFoto', 'totalAlbum', 'fotoPending',
            'totalKontak', 'kontakHot', 'followUpHariIni',
            'totalPesan', 'pesanUnread',
            // Pages
            'totalPages', 'publishedPages', 'latestPage',
            // Team
            'totalTeam', 'totalTeamAktif', 'totalTeamNonaktif',
            // Statistik Persentase
            'persentaseClusterAktif',
            'persentaseUnitTerjual',
            'persentaseHunian',
            'persentaseBeritaPublished',
            // Statistik Cepat
            'prospekBaru', 'dealClosing', 'kunjunganHariIni',
            // Aktivitas
            'activities'
        ));
    }
}