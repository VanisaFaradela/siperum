<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $search = $request->input('search');
        $kategori = $request->input('kategori_foto');
        $status = $request->input('status');

        $galeri = Galeri::query()
            ->when($search, function ($query, $search) {
                return $query->where('judul_galeri', 'like', "%{$search}%");
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori_foto', $kategori);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('urutan', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $kategoriList = Galeri::distinct('kategori_foto')->pluck('kategori_foto');
        $totalGaleri = Galeri::count();
        $totalAktif = Galeri::where('status', 'aktif')->count();

        return view('galeri.index', compact('galeri', 'kategoriList', 'totalGaleri', 'totalAktif'));
    }

    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        // Hanya 2 kategori sesuai ENUM database
        $kategoriList = ['fasilitas umum', 'event'];
        return view('galeri.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'judul_galeri' => 'nullable|string|max:150',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'kategori_foto' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $data = $request->only(['judul_galeri', 'kategori_foto', 'urutan', 'status']);
        $data['id_perumahan'] = 1;
        $data['tanggal_upload'] = now()->toDateString();
        
        // Mapping kategori_foto ke kolom kategori (ENUM)
        $kategoriEnum = $this->mapKategoriToEnum($data['kategori_foto']);
        $data['kategori'] = $kategoriEnum;

        if ($request->hasFile('foto')) {

        $foto = $request->file('foto');

        $namaFoto = time() . '_' . preg_replace(
            '/[^a-zA-Z0-9._-]/',
            '',
            $foto->getClientOriginalName()
        );

        $tujuanShared = '/home/u143856011/shared/uploads/galeri';

        if (!file_exists($tujuanShared)) {
            mkdir($tujuanShared, 0777, true);
        }

        $foto->move($tujuanShared, $namaFoto);

        // Simpan path database
       $data['foto'] = $namaFoto;
    }

        Galeri::create($data);

        return redirect()->route('galeri.index')
            ->with('success', 'Foto berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $galeri = Galeri::findOrFail($id);
        $kategoriList = ['fasilitas umum', 'event'];
        return view('galeri.edit', compact('galeri', 'kategoriList'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $galeri = Galeri::findOrFail($id);
        
        $request->validate([
            'judul_galeri' => 'nullable|string|max:150',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'kategori_foto' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $data = $request->only(['judul_galeri', 'kategori_foto', 'urutan', 'status']);
        
        // Mapping kategori_foto ke kolom kategori (ENUM)
        $kategoriEnum = $this->mapKategoriToEnum($data['kategori_foto']);
        $data['kategori'] = $kategoriEnum;

        // Hapus foto jika dicentang
        if ($request->has('hapus_foto')) {
            if ($galeri->foto && file_exists(public_path($galeri->foto))) {
                unlink(public_path($galeri->foto));
            }
            $data['foto'] = null;
        }

        if ($request->hasFile('foto')) {

        // Hapus foto lama ADMIN
        if ($galeri->foto && file_exists(public_path($galeri->foto))) {
            unlink(public_path($galeri->foto));
        }

        $fotoLama = '/home/u143856011/shared/uploads/galeri/' . $galeri->foto;

        if ($galeri->foto && file_exists($fotoLama)) {
            unlink($fotoLama);
        }

        $foto = $request->file('foto');

        $namaFoto = time() . '_' . preg_replace(
            '/[^a-zA-Z0-9._-]/',
            '',
            $foto->getClientOriginalName()
        );

        // PATH ADMIN
        $tujuanAdmin = public_path('uploads/galeri');

        // PATH FRONTEND
        $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/galeri';

        // Buat folder jika belum ada
        if (!file_exists($tujuanAdmin)) {
            mkdir($tujuanAdmin, 0777, true);
        }

        if (!file_exists($tujuanFrontend)) {
            mkdir($tujuanFrontend, 0777, true);
        }

        // Upload ke ADMIN
        $foto->move($tujuanAdmin, $namaFoto);

        // Copy ke FRONTEND
        copy(
            $tujuanAdmin . '/' . $namaFoto,
            $tujuanFrontend . '/' . $namaFoto
        );

        $data['foto'] = 'uploads/galeri/' . $namaFoto;
    }

        $galeri->update($data);

        return redirect()->route('galeri.index')
            ->with('success', 'Foto berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $galeri = Galeri::findOrFail($id);
        
        $fotoPath = '/home/u143856011/shared/uploads/galeri/' . $galeri->foto;

        if ($galeri->foto && file_exists($fotoPath)) {
            unlink($fotoPath);
        }

        $galeri->delete();

        return redirect()->route('galeri.index')
            ->with('success', 'Foto berhasil dihapus!');
    }

    public function updateOrder(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['success' => false], 403);
        }
        
        foreach ($request->order as $id => $urutan) {
            Galeri::where('id_galeri', $id)->update(['urutan' => $urutan]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Map kategori_foto ke nilai ENUM yang valid di kolom kategori
     */
    private function mapKategoriToEnum($kategoriFoto)
    {
        $mapping = [
            'fasilitas' => 'fasilitas umum',
            'fasilitas umum' => 'fasilitas umum',
            'event' => 'event',
            'rumah' => 'fasilitas umum', // mapping rumah ke fasilitas umum
            'lingkungan' => 'fasilitas umum',
            'umum' => 'fasilitas umum',
            'promo' => 'event',
        ];
        
        return $mapping[$kategoriFoto] ?? 'fasilitas umum';
    }
}