<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

            $gambar = $request->file('gambar');

            $namaGambar = time() . '_' . preg_replace(
                '/[^a-zA-Z0-9._-]/',
                '',
                $gambar->getClientOriginalName()
            );

            Storage::disk('shared_uploads')->putFileAs(
                'berita',
                $gambar,
                $namaGambar
            );

            $data['gambar'] = $namaGambar;
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
            
            if ($berita->gambar) {
                Storage::disk('shared_uploads')
                    ->delete('berita/' . $berita->gambar);
            }

            $data['gambar'] = null;
        }

        // UPLOAD GAMBAR BARU
        if ($request->hasFile('gambar')) {

            if ($berita->gambar) {
                Storage::disk('shared_uploads')
                    ->delete('berita/' . $berita->gambar);
            }

            $gambar = $request->file('gambar');

            $namaGambar = time() . '_' . preg_replace(
                '/[^a-zA-Z0-9._-]/',
                '',
                $gambar->getClientOriginalName()
            );

            Storage::disk('shared_uploads')->putFileAs(
                'berita',
                $gambar,
                $namaGambar
            );

            $data['gambar'] = $namaGambar;
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

        Storage::disk('shared_uploads')
            ->delete('berita/' . $berita->gambar);

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