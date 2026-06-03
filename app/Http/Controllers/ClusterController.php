<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\TipeRumah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClusterController extends Controller
{
    // PATH FRONTEND
    private const FRONTEND_UPLOAD_PATH = 'C:/laragon/www/perumahan-web/public/uploads/cluster/';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $search = $request->input('search');
        $kota = $request->input('kota');
        $status = $request->input('status');

        $clusters = Cluster::with('tipeRumah')
            ->when($search, function ($query, $search) {
                return $query->where('nama_cluster', 'like', "%{$search}%")
                             ->orWhere('lokasi_cluster', 'like', "%{$search}%")
                             ->orWhere('kota', 'like', "%{$search}%");
            })
            ->when($kota, function ($query, $kota) {
                return $query->where('kota', $kota);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $kotaList = Cluster::distinct('kota')->pluck('kota');
        $totalCluster = Cluster::count();
        $totalAktif = Cluster::where('status', 'aktif')->count();
        
        // Hitung total unit dari cluster (authoritative) dan terjual dari count tipe rumah status_unit='terjual'
        $totalUnit = Cluster::sum('total_unit');
        $totalTerjual = TipeRumah::where('status_unit', 'terjual')->count();

        foreach ($clusters as $item) {
            // Hitung unit_terjual dari count tipe rumah dengan status_unit='terjual'
            $unitSold = $item->tipeRumah->where('status_unit', 'terjual')->count();
            $unitBooking = $item->tipeRumah->where('status_unit', 'booking')->count();
            
            $item->unit_terjual = $unitSold;
            $item->unit_tersedia = $item->total_unit - $unitSold - $unitBooking;
            if ($item->unit_tersedia < 0) $item->unit_tersedia = 0;
            
            $item->persentase_terjual = $item->total_unit > 0 
                ? round(($unitSold / $item->total_unit) * 100) 
                : 0;
        }

        return view('cluster.index', compact(
            'clusters', 'kotaList', 'totalCluster',
            'totalAktif', 'totalUnit', 'totalTerjual'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $statusList = ['aktif', 'nonaktif', 'draft'];
        $sertifikatList = ['SHM', 'HGB', 'HPL', 'Lainnya'];
        $listrikList = ['450', '900', '1300', '2200', '3500', '4400+'];
        
        return view('cluster.create', compact('statusList', 'sertifikatList', 'listrikList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $cluster = Cluster::where('cluster_id', $id)->firstOrFail();
        
        if ($cluster->fasilitas && is_string($cluster->fasilitas)) {
            $cluster->fasilitas = json_decode($cluster->fasilitas, true);
        }
        
        if ($cluster->foto_lainnya && is_string($cluster->foto_lainnya)) {
            $cluster->foto_lainnya = json_decode($cluster->foto_lainnya, true);
        }
        
        $statusList = ['aktif', 'nonaktif', 'draft'];
        $sertifikatList = ['SHM', 'HGB', 'HPL', 'Lainnya'];
        $listrikList = ['450', '900', '1300', '2200', '3500', '4400+'];

        $fasilitasTerpilih = is_array($cluster->fasilitas)
            ? $cluster->fasilitas
            : [];
        
        return view('cluster.edit', compact(
            'cluster',
            'statusList',
            'sertifikatList',
            'listrikList',
            'fasilitasTerpilih'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        $cluster = Cluster::where('cluster_id', $id)->firstOrFail();

        $request->validate([
            'nama_cluster' => 'required|min:3|max:255',
            'lokasi_cluster' => 'nullable|string',
            'kota' => 'required',
            'provinsi' => 'required',
            'nama_pengembang' => 'required',
            'kontak_pengembang' => 'required',
            'total_unit' => 'required|integer|min:0',
            'unit_tersedia' => 'required|integer|min:0',
            'logo_cluster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_cluster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->all();

        $data['unit_terjual'] =
            $data['total_unit'] - $data['unit_tersedia'];

        $data['akses_air_bersih'] =
            $request->has('akses_air_bersih') ? 1 : 0;

        $data['keamanan_24jam'] =
            $request->has('keamanan_24jam') ? 1 : 0;

        $data['one_gate_system'] =
            $request->has('one_gate_system') ? 1 : 0;

        // =========================
        // UPDATE LOGO
        // =========================
        if ($request->hasFile('logo_cluster')) {

            // hapus lama admin
            if ($cluster->logo_cluster) {

                $logoAdmin = public_path($cluster->logo_cluster);

                if (file_exists($logoAdmin)) {
                    unlink($logoAdmin);
                }

                // hapus lama frontend
                $logoFrontend =
                    'C:/laragon/www/perumahan-web/public/' .
                    $cluster->logo_cluster;

                if (file_exists($logoFrontend)) {
                    unlink($logoFrontend);
                }
            }

            $logo = $request->file('logo_cluster');

            $namaLogo = time() . '_logo_' .
                preg_replace(
                    '/[^a-zA-Z0-9._-]/',
                    '',
                    $logo->getClientOriginalName()
                );

            // ADMIN
            $tujuanAdmin = public_path('uploads/cluster/logo');

            if (!file_exists($tujuanAdmin)) {
                mkdir($tujuanAdmin, 0777, true);
            }

            copy(
                $logo->getRealPath(),
                $tujuanAdmin . '/' . $namaLogo
            );

            // FRONTEND
            $tujuanFrontend =
                self::FRONTEND_UPLOAD_PATH . 'logo';

            if (!file_exists($tujuanFrontend)) {
                mkdir($tujuanFrontend, 0777, true);
            }

            copy(
                $logo->getRealPath(),
                $tujuanFrontend . '/' . $namaLogo
            );

            $data['logo_cluster'] =
                'uploads/cluster/logo/' . $namaLogo;
        }

        // =========================
        // UPDATE GAMBAR
        // =========================
        if ($request->hasFile('gambar_cluster')) {

            if ($cluster->gambar_cluster) {

                $gambarAdmin =
                    public_path($cluster->gambar_cluster);

                if (file_exists($gambarAdmin)) {
                    unlink($gambarAdmin);
                }

                $gambarFrontend =
                    'C:/laragon/www/perumahan-web/public/' .
                    $cluster->gambar_cluster;

                if (file_exists($gambarFrontend)) {
                    unlink($gambarFrontend);
                }
            }

            $gambar = $request->file('gambar_cluster');

            $namaGambar = time() . '_gambar_' .
                preg_replace(
                    '/[^a-zA-Z0-9._-]/',
                    '',
                    $gambar->getClientOriginalName()
                );

            // ADMIN
            $tujuanAdmin =
                public_path('uploads/cluster/gambar');

            if (!file_exists($tujuanAdmin)) {
                mkdir($tujuanAdmin, 0777, true);
            }

            copy(
                $gambar->getRealPath(),
                $tujuanAdmin . '/' . $namaGambar
            );

            // FRONTEND
            $tujuanFrontend =
                self::FRONTEND_UPLOAD_PATH . 'gambar';

            if (!file_exists($tujuanFrontend)) {
                mkdir($tujuanFrontend, 0777, true);
            }

            copy(
                $gambar->getRealPath(),
                $tujuanFrontend . '/' . $namaGambar
            );

            $data['gambar_cluster'] =
                'uploads/cluster/gambar/' . $namaGambar;
        }

        $cluster->update($data);

        return redirect()->route('cluster.index')
            ->with('success', 'Cluster berhasil diperbarui!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'nama_cluster' => 'required|min:3|max:255',
            'lokasi_cluster' => 'nullable|string',
            'kota' => 'required',
            'provinsi' => 'required',
            'nama_pengembang' => 'required',
            'kontak_pengembang' => 'required',
            'total_unit' => 'required|integer|min:0',
            'unit_tersedia' => 'required|integer|min:0',
            'logo_cluster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_cluster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->all();
        
        $data['unit_terjual'] = $data['total_unit'] - $data['unit_tersedia'];
        $data['slug'] = Str::slug($data['nama_cluster']);
        
        $count = Cluster::where('slug', $data['slug'])->count();
        if ($count > 0) {
            $data['slug'] = $data['slug'] . '-' . ($count + 1);
        }

        if ($request->has('fasilitas')) {

            $fasilitasArray = $request->input('fasilitas', []);
            
            if (is_string($fasilitasArray)) {
                $fasilitasArray = explode(',', $fasilitasArray);
            }
            
            $data['fasilitas'] = $fasilitasArray;

        } else {
            $data['fasilitas'] = [];
        }

        $data['akses_air_bersih'] = $request->has('akses_air_bersih') ? 1 : 0;
        $data['keamanan_24jam'] = $request->has('keamanan_24jam') ? 1 : 0;
        $data['one_gate_system'] = $request->has('one_gate_system') ? 1 : 0;

        if (empty($data['status'])) {
            $data['status'] = 'draft';
        }

        // =========================
        // LOGO CLUSTER
        // =========================
        if ($request->hasFile('logo_cluster')) {

            $logo = $request->file('logo_cluster');

            $namaLogo = time() . '_logo_' .
                preg_replace('/[^a-zA-Z0-9._-]/', '', $logo->getClientOriginalName());

            // ADMIN
            $tujuanAdmin = public_path('uploads/cluster/logo');

            if (!file_exists($tujuanAdmin)) {
                mkdir($tujuanAdmin, 0777, true);
            }

            copy(
                $logo->getRealPath(),
                $tujuanAdmin . '/' . $namaLogo
            );

            // FRONTEND
            $tujuanFrontend = self::FRONTEND_UPLOAD_PATH . 'logo';

            if (!file_exists($tujuanFrontend)) {
                mkdir($tujuanFrontend, 0777, true);
            }

            copy(
                $logo->getRealPath(),
                $tujuanFrontend . '/' . $namaLogo
            );

            $data['logo_cluster'] = 'uploads/cluster/logo/' . $namaLogo;
        }

        // =========================
        // GAMBAR CLUSTER
        // =========================
        if ($request->hasFile('gambar_cluster')) {

            $foto = $request->file('gambar_cluster');

            $namaFoto = time() . '_gambar_' .
                preg_replace('/[^a-zA-Z0-9._-]/', '', $foto->getClientOriginalName());

            // ADMIN
            $tujuanAdmin = public_path('uploads/cluster/gambar');

            if (!file_exists($tujuanAdmin)) {
                mkdir($tujuanAdmin, 0777, true);
            }

            copy(
                $foto->getRealPath(),
                $tujuanAdmin . '/' . $namaFoto
            );

            // FRONTEND
            $tujuanFrontend = self::FRONTEND_UPLOAD_PATH . 'gambar';

            if (!file_exists($tujuanFrontend)) {
                mkdir($tujuanFrontend, 0777, true);
            }

            copy(
                $foto->getRealPath(),
                $tujuanFrontend . '/' . $namaFoto
            );

            $data['gambar_cluster'] = 'uploads/cluster/gambar/' . $namaFoto;
        }

        // =========================
        // FOTO LAINNYA
        // =========================
        if ($request->hasFile('foto_lainnya')) {

            $fotoBaru = [];

            foreach ($request->file('foto_lainnya') as $file) {

                $namaFile = time() . '_' . uniqid() . '_' .
                    preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());

                // ADMIN
                $tujuanAdmin = public_path('uploads/cluster/foto');

                if (!file_exists($tujuanAdmin)) {
                    mkdir($tujuanAdmin, 0777, true);
                }

                copy(
                    $file->getRealPath(),
                    $tujuanAdmin . '/' . $namaFile
                );

                // FRONTEND
                $tujuanFrontend = self::FRONTEND_UPLOAD_PATH . 'foto';

                if (!file_exists($tujuanFrontend)) {
                    mkdir($tujuanFrontend, 0777, true);
                }

                copy(
                    $file->getRealPath(),
                    $tujuanFrontend . '/' . $namaFile
                );

                $fotoBaru[] = 'uploads/cluster/foto/' . $namaFile;
            }

            $data['foto_lainnya'] = json_encode($fotoBaru);
        }

        Cluster::create($data);

        return redirect()->route('cluster.index')
            ->with('success', 'Cluster berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cluster = Cluster::where('cluster_id', $id)
            ->orWhere('slug', $id)
            ->firstOrFail();
        
        if ($cluster->fasilitas && is_string($cluster->fasilitas)) {
            $cluster->fasilitas = json_decode($cluster->fasilitas, true);
        }
        
        $cluster->increment('views');

        $cluster->load('tipeRumah');

        // Hitung unit berdasarkan status tiap tipe rumah (status_unit)
        // - 'terjual' => terjual
        // - 'booking' => booking
        // - lainnya (termasuk status 'promo') => tersedia
        $unitSold = $cluster->tipeRumah->where('status_unit', 'terjual')->count();
        $unitBooking = $cluster->tipeRumah->where('status_unit', 'booking')->count();

        // Jika cluster memiliki total_unit yang ditetapkan, gunakan itu sebagai basis
        $totalUnit = $cluster->total_unit ?? 0;

        // Unit tersedia dihitung dari selisih total - terjual - booking
        $unitAvailable = $totalUnit - $unitSold - $unitBooking;
        if ($unitAvailable < 0) $unitAvailable = 0;

        $cluster->unit_terjual = $unitSold;
        $cluster->unit_tersedia = $unitAvailable;

        $cluster->persentase_terjual = $totalUnit > 0
            ? round(($unitSold / $totalUnit) * 100)
            : 0;
        
        $clusterTerkait = Cluster::where('kota', $cluster->kota)
            ->where('cluster_id', '!=', $cluster->cluster_id)
            ->where('status', 'aktif')
            ->limit(4)
            ->get();

        return view('cluster.show', compact('cluster', 'clusterTerkait'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $cluster = Cluster::where('cluster_id', $id)->firstOrFail();

        // =========================
        // HAPUS LOGO
        // =========================
        if ($cluster->logo_cluster) {

            // ADMIN
            $logoAdmin = public_path($cluster->logo_cluster);

            if (file_exists($logoAdmin)) {
                unlink($logoAdmin);
            }

            // FRONTEND
            $logoFrontend =
                'C:/laragon/www/perumahan-web/public/' . $cluster->logo_cluster;

            if (file_exists($logoFrontend)) {
                unlink($logoFrontend);
            }
        }

        // =========================
        // HAPUS GAMBAR
        // =========================
        if ($cluster->gambar_cluster) {

            // ADMIN
            $gambarAdmin = public_path($cluster->gambar_cluster);

            if (file_exists($gambarAdmin)) {
                unlink($gambarAdmin);
            }

            // FRONTEND
            $gambarFrontend =
                'C:/laragon/www/perumahan-web/public/' . $cluster->gambar_cluster;

            if (file_exists($gambarFrontend)) {
                unlink($gambarFrontend);
            }
        }

        // =========================
        // HAPUS FOTO LAINNYA
        // =========================
        if ($cluster->foto_lainnya) {

            $fotoLainnya = is_string($cluster->foto_lainnya)
                ? json_decode($cluster->foto_lainnya, true)
                : $cluster->foto_lainnya;

            if (is_array($fotoLainnya)) {

                foreach ($fotoLainnya as $foto) {

                    if ($foto) {

                        // ADMIN
                        $fotoAdmin = public_path($foto);

                        if (file_exists($fotoAdmin)) {
                            unlink($fotoAdmin);
                        }

                        // FRONTEND
                        $fotoFrontend =
                            'C:/laragon/www/perumahan-web/public/' . $foto;

                        if (file_exists($fotoFrontend)) {
                            unlink($fotoFrontend);
                        }
                    }
                }
            }
        }

        $cluster->delete();

        return redirect()->route('cluster.index')
            ->with('success', 'Cluster berhasil dihapus!');
    }
}