<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\TipeRumah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TipeRumahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        $query = TipeRumah::with('cluster');
        $cluster = null;

        // Filter cluster
        if ($request->filled('cluster_id')) {

           $cluster = Cluster::findOrFail($request->cluster_id);

            $query->where(
                'cluster_id',
                $request->cluster_id
            );
        }

        // Search nama tipe
        if ($request->filled('search')) {
            $query->where(
                'nama_tipe',
                'like',
                '%' . $request->search . '%'
            );
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        // Sorting
        switch ($request->sort) {

            case 'harga_asc':
                $query->orderBy('harga', 'asc');
                break;

            case 'harga_desc':
                $query->orderBy('harga', 'desc');
                break;

            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $tipeRumah = $query->paginate(15);

        // Statistik
       $totalTersedia = TipeRumah::where('status_unit', 'tersedia')->count();
       $totalBooking  = TipeRumah::where('status_unit', 'booking')->count();
       $totalTerjual  = TipeRumah::where('status_unit', 'terjual')->count();

        return view(
            'tipe-rumah.index',
            compact(
                'tipeRumah',
                'cluster',
                'totalTersedia',
                'totalBooking',
                'totalTerjual'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $clusterId = $request->query('cluster_id');
        
        // Ambil semua cluster aktif untuk dropdown
        $clusters = Cluster::where('status', 'aktif')
            ->orderBy('nama_cluster')
            ->get();

        return view('tipe-rumah.create', compact('clusters', 'clusterId'));
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
            'cluster_id' => 'required|exists:cluster,id_cluster',
            'nama_tipe' => 'required|min:3|max:255',
            'luas_bangunan' => 'nullable|numeric|min:0',
            'luas_tanah' => 'nullable|numeric|min:0',
            'kamar_tidur' => 'nullable|integer|min:0',
            'kamar_mandi' => 'nullable|integer|min:0',
            'parkiran' => 'nullable|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'harga_promo' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:tersedia,promo,habis',
            'blok' => 'nullable|string|max:10',
            'nomor_unit' => 'nullable|string|max:10',
            'status_unit' => 'nullable|string|in:tersedia,booking,terjual',
            'deskripsi' => 'nullable|string',
            'foto_denah' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_rumah.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        $data['total_unit'] = 1;
        
        // Hapus file dari data
        unset($data['foto_denah']);
        unset($data['foto_rumah']);
        
        // Set default status
        if (empty($data['status']) || !in_array($data['status'], ['tersedia', 'promo', 'habis'])) {
            $data['status'] = 'tersedia';
        }

       if (($data['status'] ?? null) === 'habis') {
            $data['status_unit'] = 'terjual';
        }

        if (empty($data['status_unit']) || $data['status_unit'] === 'tersedia') {
            $data['status_unit'] = 'tersedia';
            $data['unit_tersedia'] = 1;
            $data['unit_terjual'] = 0;
        } elseif ($data['status_unit'] === 'booking') {
            $data['unit_tersedia'] = 0;
            $data['unit_terjual'] = 0;
        } else {
            $data['unit_tersedia'] = 0;
            $data['unit_terjual'] = 1;
        }
        
        // Buat slug
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama_tipe']);
        }
        
        $count = TipeRumah::where('slug', $data['slug'])->count();
        if ($count > 0) {
            $data['slug'] = $data['slug'] . '-' . ($count + 1);
        }

        // ================= FOTO DENAH =================
        if ($request->hasFile('foto_denah')) {
            $file = $request->file('foto_denah');
            $namaFile = time() . '_' . uniqid() . '_' .preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $tujuanShared = '/home/u143856011/shared/uploads/tipe-rumah';

            if (!file_exists($tujuanShared)) {
                mkdir($tujuanShared, 0775, true);
            }

            $file->move($tujuanShared, $namaFile);

            $data['foto_denah'] = $namaFile;
        }

        // ================= FOTO RUMAH =================
        if ($request->hasFile('foto_rumah')) {
            $fotoArray = [];

            foreach ($request->file('foto_rumah') as $file) {
                $namaFile = time() . '_' . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $tujuanShared = '/home/u143856011/shared/uploads/tipe-rumah';

                if (!file_exists($tujuanShared)) {
                    mkdir($tujuanShared, 0775, true);
                }

                $file->move($tujuanShared, $namaFile);
                $fotoArray[] = $namaFile;
            }

            $data['foto_rumah'] = json_encode($fotoArray);
        }

        $tipeRumah = TipeRumah::create($data);

       $cluster = Cluster::findOrFail($tipeRumah->cluster_id);

        return redirect()->route('cluster.show', $cluster->slug)
            ->with('success', 'Tipe rumah berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $tipeRumah = TipeRumah::with('cluster')
            ->where('id_tipe', $id)
            ->firstOrFail();
        
       $tipeLainnya = TipeRumah::where('cluster_id', $tipeRumah->cluster_id)
            ->where('id_tipe', '!=', $tipeRumah->id_tipe)
            ->limit(4)
            ->get();
        
        return view('tipe-rumah.show', compact('tipeRumah', 'tipeLainnya'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        $tipeRumah = TipeRumah::with('cluster')
            ->where('id_tipe', $id)
            ->firstOrFail();
        
        // Decode foto rumah jika JSON
        $tipeRumah->foto_rumah_array = [];

        if ($tipeRumah->foto_rumah) {
            $fotoRumah = json_decode($tipeRumah->foto_rumah, true);

            if (is_array($fotoRumah)) {
                $tipeRumah->foto_rumah_array = $fotoRumah;
            }
        }
        
        $clusters = Cluster::where('status', 'aktif')
            ->orderBy('nama_cluster')
            ->get();

        return view('tipe-rumah.edit', compact('tipeRumah', 'clusters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $tipeRumah = TipeRumah::where('id_tipe', $id)->firstOrFail();
        
        $request->validate([
            'cluster_id' => 'required|exists:cluster,id_cluster',
            'nama_tipe' => 'required|min:3|max:255',
            'luas_bangunan' => 'nullable|numeric|min:0',
            'luas_tanah' => 'nullable|numeric|min:0',
            'kamar_tidur' => 'nullable|integer|min:0',
            'kamar_mandi' => 'nullable|integer|min:0',
            'parkiran' => 'nullable|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'harga_promo' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:tersedia,promo,habis',
            'blok' => 'nullable|string|max:10',
            'nomor_unit' => 'nullable|string|max:10',
            'status_unit' => 'nullable|string|in:tersedia,booking,terjual',
            'deskripsi' => 'nullable|string',
            'foto_denah' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_rumah.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        $data['total_unit'] = 1;
        
        // Hapus file dari data
        unset($data['foto_denah']);
        unset($data['foto_rumah']);
        unset($data['_token']);
        unset($data['_method']);
        
       if (($data['status'] ?? '') === 'habis') {
            $data['status_unit'] = 'terjual';
        }

        if (empty($data['status_unit']) || $data['status_unit'] === 'tersedia') {
            $data['status_unit'] = 'tersedia';
            $data['unit_tersedia'] = 1;
            $data['unit_terjual'] = 0;
        } elseif ($data['status_unit'] === 'booking') {
            $data['unit_tersedia'] = 0;
            $data['unit_terjual'] = 0;
        } else {
            $data['unit_tersedia'] = 0;
            $data['unit_terjual'] = 1;
        }

        // ================= HAPUS FOTO DENAH =================
        if ($request->has('hapus_foto_denah')) {
            if ($tipeRumah->foto_denah) {

                $path =
                    '/home/u143856011/shared/uploads/tipe-rumah/' .
                    basename($tipeRumah->foto_denah);

                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $data['foto_denah'] = null;
        }

        // ================= UPLOAD FOTO DENAH BARU =================
        if ($request->hasFile('foto_denah')) {
           if ($tipeRumah->foto_denah) {

                $path =
                    '/home/u143856011/shared/uploads/tipe-rumah/' .
                    basename($tipeRumah->foto_denah);

                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $file = $request->file('foto_denah');
            $namaFile = time() . '_denah_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $tujuanShared = '/home/u143856011/shared/uploads/tipe-rumah';

            if (!file_exists($tujuanShared)) {
                mkdir($tujuanShared, 0775, true);
            }

            $file->move($tujuanShared, $namaFile);

            $data['foto_denah'] = $namaFile;
        }

        // ================= FOTO RUMAH LAMA =================
        $fotoRumahLama = [];

        if ($tipeRumah->foto_rumah) {
            if (is_string($tipeRumah->foto_rumah)) {
                $decoded = json_decode($tipeRumah->foto_rumah, true);
                if (is_array($decoded)) {
                    $fotoRumahLama = $decoded;
                }
            } elseif (is_array($tipeRumah->foto_rumah)) {
                $fotoRumahLama = $tipeRumah->foto_rumah;
            }
        }

        if (!is_array($fotoRumahLama)) {
            $fotoRumahLama = [];
        }

        // ================= HAPUS FOTO RUMAH =================
        if ($request->has('hapus_foto') && is_array($request->hapus_foto)) {
            foreach ($request->hapus_foto as $index) {
               if (isset($fotoRumahLama[$index])) {

                    $path =
                        '/home/u143856011/shared/uploads/tipe-rumah/' .
                        basename($fotoRumahLama[$index]);

                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                unset($fotoRumahLama[$index]);
            }
        }

        // ================= UPLOAD FOTO RUMAH BARU =================
        if ($request->hasFile('foto_rumah')) {
            $fotoBaru = [];

            foreach ($request->file('foto_rumah') as $file) {
                $namaFile = time() . '_' . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $tujuanShared = '/home/u143856011/shared/uploads/tipe-rumah';

                if (!file_exists($tujuanShared)) {
                    mkdir($tujuanShared, 0775, true);
                }

                $file->move($tujuanShared, $namaFile);

                $fotoBaru[] = $namaFile;
            }

            $fotoRumahLama = array_merge($fotoRumahLama, $fotoBaru);
        }

        $data['foto_rumah'] = !empty($fotoRumahLama) ? json_encode(array_values($fotoRumahLama)) : null;

        if (empty($data['status'])) {
            $data['status'] = 'tersedia';
        }

        // Update slug jika judul berubah
        if ($request->nama_tipe != $tipeRumah->nama_tipe) {
            $data['slug'] = Str::slug($request->nama_tipe);
            $count = TipeRumah::where('slug', $data['slug'])->where('id_tipe', '!=', $id)->count();
            if ($count > 0) {
                $data['slug'] = $data['slug'] . '-' . ($count + 1);
            }
        }

        $tipeRumah->update($data);

        return redirect()->route('tipe-rumah.index')
            ->with('success', 'Tipe rumah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $tipeRumah = TipeRumah::where('id_tipe', $id)->firstOrFail();

        if ($tipeRumah->foto_denah) {

            $path =
                '/home/u143856011/shared/uploads/tipe-rumah/' .
                basename($tipeRumah->foto_denah);

            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Hapus foto rumah
        if ($tipeRumah->foto_rumah) {
            $fotoRumah = is_string($tipeRumah->foto_rumah) ? json_decode($tipeRumah->foto_rumah, true) : $tipeRumah->foto_rumah;
            if (is_array($fotoRumah)) {
                foreach ($fotoRumah as $foto) {
                    $path =
                        '/home/u143856011/shared/uploads/tipe-rumah/' .
                        basename($foto);

                    if ($foto && file_exists($path)) {
                        unlink($path);
                    }
                }
            }
        }

       $cluster = Cluster::findOrFail($tipeRumah->cluster_id);

        return redirect()->route('cluster.show', $cluster->slug)
            ->with('success', 'Tipe rumah berhasil dihapus!');
    }
}