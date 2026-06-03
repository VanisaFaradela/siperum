<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $search = $request->input('search');
        $kategori = $request->input('kategori');
        $status = $request->input('status');

        $berita = Berita::query()
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('konten', 'like', "%{$search}%");
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $kategoriList = Berita::distinct('kategori')->pluck('kategori');
        $totalBerita = Berita::count();
        $totalPublished = Berita::where('status', 'published')->count();
        $totalDraft = Berita::where('status', 'draft')->count();

        return view('berita.index', compact(
            'berita', 'kategoriList', 'totalBerita', 'totalPublished', 'totalDraft'
        ));
    }

    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $kategoriList = ['Info cluster', 'Tips & Trik', 'Promo', 'Event', 'Pengumuman', 'Artikel'];
        return view('berita.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'judul' => 'required|min:5|max:255',
            'konten' => 'required|min:10',
            'kategori' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        $data = $request->all();
        $data['penulis'] = Auth::guard('admin')->user()->name ?? 'Admin';
        $data['slug'] = Str::slug($request->judul);

        // Cek slug duplicate
        $count = Berita::where('slug', $data['slug'])->count();
        if ($count > 0) {
            $data['slug'] = $data['slug'] . '-' . ($count + 1);
        }

        // Upload gambar
        if ($request->hasFile('gambar')) {

            $gambar = $request->file('gambar');

            $namaGambar = time() . '_' . preg_replace(
                '/[^a-zA-Z0-9._-]/',
                '',
                $gambar->getClientOriginalName()
            );

            // =========================
            // PATH ADMIN
            // =========================
            $tujuanAdmin = public_path('uploads/berita');

            // =========================
            // PATH FRONTEND
            // =========================
            $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/berita';

            // Buat folder jika belum ada
            if (!file_exists($tujuanAdmin)) {
                mkdir($tujuanAdmin, 0777, true);
            }

            if (!file_exists($tujuanFrontend)) {
                mkdir($tujuanFrontend, 0777, true);
            }

            // Upload ke ADMIN
            $gambar->move($tujuanAdmin, $namaGambar);

            // Copy ke FRONTEND
            copy(
                $tujuanAdmin . '/' . $namaGambar,
                $tujuanFrontend . '/' . $namaGambar
            );

            // Simpan ke database
            $data['gambar'] = 'uploads/berita/' . $namaGambar;
        }

        Berita::create($data);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }
    
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        $berita->increment('views');
        
        $beritaTerkait = Berita::where('kategori', $berita->kategori)
            ->where('id', '!=', $berita->id)
            ->where('status', 'published')
            ->limit(3)
            ->get();

        return view('berita.show', compact('berita', 'beritaTerkait'));
    }

    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        // Gunakan 'id' bukan 'id_berita'
        $berita = Berita::findOrFail($id);
        $kategoriList = ['Info cluster', 'Tips & Trik', 'Promo', 'Event', 'Pengumuman', 'Artikel'];
        return view('berita.edit', compact('berita', 'kategoriList'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        // Gunakan 'id' bukan 'id_berita'
        $berita = Berita::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|min:5|max:255',
            'konten' => 'required|min:10',
            'kategori' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        $data = $request->all();

        // Update slug jika judul berubah
        if ($data['judul'] != $berita->judul) {
            $data['slug'] = Str::slug($data['judul']);
            // Cek slug duplicate
            $count = Berita::where('slug', $data['slug'])->where('id', '!=', $id)->count();
            if ($count > 0) {
                $data['slug'] = $data['slug'] . '-' . ($count + 1);
            }
        }

        // Set published_at jika status berubah dari draft ke published
        if ($request->status == 'published' && $berita->status != 'published') {
            $data['published_at'] = now();
        }

        // HAPUS GAMBAR JIKA DICENTANG
        if ($request->has('hapus_gambar') && $request->hapus_gambar == 1) {
            if ($berita->gambar && file_exists(public_path($berita->gambar))) {
                unlink(public_path($berita->gambar));
            }
            $data['gambar'] = null;
        }

        // UPLOAD GAMBAR BARU
        if ($request->hasFile('gambar')) {

            // =========================
            // HAPUS GAMBAR LAMA ADMIN
            // =========================
            if ($berita->gambar && file_exists(public_path($berita->gambar))) {
                unlink(public_path($berita->gambar));
            }

            // =========================
            // HAPUS GAMBAR LAMA FRONTEND
            // =========================
            $gambarFrontendLama = 'C:/laragon/www/perumahan-web/public/' . $berita->gambar;

            if ($berita->gambar && file_exists($gambarFrontendLama)) {
                unlink($gambarFrontendLama);
            }

            $gambar = $request->file('gambar');

            $namaGambar = time() . '_' . preg_replace(
                '/[^a-zA-Z0-9._-]/',
                '',
                $gambar->getClientOriginalName()
            );

            // =========================
            // PATH ADMIN
            // =========================
            $tujuanAdmin = public_path('uploads/berita');

            // =========================
            // PATH FRONTEND
            // =========================
            $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/berita';

            // Buat folder jika belum ada
            if (!file_exists($tujuanAdmin)) {
                mkdir($tujuanAdmin, 0777, true);
            }

            if (!file_exists($tujuanFrontend)) {
                mkdir($tujuanFrontend, 0777, true);
            }

            // Upload ke ADMIN
            $gambar->move($tujuanAdmin, $namaGambar);

            // Copy ke FRONTEND
            copy(
                $tujuanAdmin . '/' . $namaGambar,
                $tujuanFrontend . '/' . $namaGambar
            );

            // Simpan ke database
            $data['gambar'] = 'uploads/berita/' . $namaGambar;
        }

        $berita->update($data);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        // Gunakan 'id' bukan 'id_berita'
        $berita = Berita::findOrFail($id);

        // Hapus ADMIN
        if ($berita->gambar && file_exists(public_path($berita->gambar))) {
            unlink(public_path($berita->gambar));
        }

        // Hapus FRONTEND
        $gambarFrontend = 'C:/laragon/www/perumahan-web/public/' . $berita->gambar;

        if ($berita->gambar && file_exists($gambarFrontend)) {
            unlink($gambarFrontend);
        }

        $berita->delete();

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        // Gunakan 'id' bukan 'id_berita'
        $berita = Berita::findOrFail($id);
        
        if ($berita->status == 'draft') {
            $berita->update([
                'status' => 'published',
                'published_at' => now()
            ]);
            $message = 'Berita dipublikasikan!';
        } else {
            $berita->update(['status' => 'draft']);
            $message = 'Berita diubah ke draft!';
        }

        return redirect()->back()->with('success', $message);
    }
}