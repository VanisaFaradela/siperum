<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // ==================== BACKEND (CRUD) ====================
    
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $pages = Page::orderBy('order')->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.index', compact('pages'));
    }

    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        return view('pages.create');
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video' => 'nullable|url|max:255',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        
        // Cek slug duplicate
        $count = Page::where('slug', $data['slug'])->count();
        if ($count > 0) {
            $data['slug'] = $data['slug'] . '-' . ($count + 1);
        }

        // Set default order
        $maxOrder = Page::max('order');
        $data['order'] = $maxOrder + 1;

        // Upload gambar
        if ($request->hasFile('featured_image')) {

            $image = $request->file('featured_image');

            $namaImage = time() . '_' . preg_replace(
                '/[^a-zA-Z0-9._-]/',
                '',
                $image->getClientOriginalName()
            );

            // PATH ADMIN
            $tujuanAdmin = public_path('uploads/pages');

            // PATH FRONTEND
            $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/pages';

            // Buat folder jika belum ada
            if (!file_exists($tujuanAdmin)) {
                mkdir($tujuanAdmin, 0777, true);
            }

            if (!file_exists($tujuanFrontend)) {
                mkdir($tujuanFrontend, 0777, true);
            }

            // Upload ke ADMIN
            $image->move($tujuanAdmin, $namaImage);

            // Copy ke FRONTEND
            copy(
                $tujuanAdmin . '/' . $namaImage,
                $tujuanFrontend . '/' . $namaImage
            );

            $data['featured_image'] = 'uploads/pages/' . $namaImage;
        }

        // Handle video
        if ($request->filled('video')) {
            $data['video'] = $request->video;
        }

        // Simpan meta data SEO
        $data['meta_data'] = json_encode([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        Page::create($data);

        return redirect()->route('pages.index')
            ->with('success', 'Halaman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $page = Page::findOrFail($id);
        return view('pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video' => 'nullable|url|max:255',
        ]);

        $data = $request->all();
        
        // Update slug jika judul berubah
        if ($request->title != $page->title) {
            $data['slug'] = Str::slug($request->title);
            $count = Page::where('slug', $data['slug'])->where('id', '!=', $id)->count();
            if ($count > 0) {
                $data['slug'] = $data['slug'] . '-' . ($count + 1);
            }
        }

        // Upload gambar baru
        if ($request->hasFile('featured_image')) {

            // Hapus gambar lama ADMIN
            if ($page->featured_image && file_exists(public_path($page->featured_image))) {
                unlink(public_path($page->featured_image));
            }

            // Hapus gambar lama FRONTEND
            $gambarFrontendLama = 'C:/laragon/www/perumahan-web/public/' . $page->featured_image;

            if ($page->featured_image && file_exists($gambarFrontendLama)) {
                unlink($gambarFrontendLama);
            }

            $image = $request->file('featured_image');

            $namaImage = time() . '_' . preg_replace(
                '/[^a-zA-Z0-9._-]/',
                '',
                $image->getClientOriginalName()
            );

            // PATH ADMIN
            $tujuanAdmin = public_path('uploads/pages');

            // PATH FRONTEND
            $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/pages';

            // Buat folder jika belum ada
            if (!file_exists($tujuanAdmin)) {
                mkdir($tujuanAdmin, 0777, true);
            }

            if (!file_exists($tujuanFrontend)) {
                mkdir($tujuanFrontend, 0777, true);
            }

            // Upload ke ADMIN
            $image->move($tujuanAdmin, $namaImage);

            // Copy ke FRONTEND
            copy(
                $tujuanAdmin . '/' . $namaImage,
                $tujuanFrontend . '/' . $namaImage
            );

            $data['featured_image'] = 'uploads/pages/' . $namaImage;
        }

        // Hapus gambar jika dicentang
        if ($request->has('hapus_image') || $request->has('hapus_gambar')) {
            if ($page->featured_image && file_exists(public_path($page->featured_image))) {
                unlink(public_path($page->featured_image));
            }
            $data['featured_image'] = null;
        }

        // Hapus video jika dicentang
        if ($request->has('hapus_video')) {
            $data['video'] = null;
        }

        // Handle video baru
        if ($request->filled('video')) {
            $data['video'] = $request->video;
        }

        // Simpan meta data SEO
        $data['meta_data'] = json_encode([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        $page->update($data);

        return redirect()->route('pages.index')
            ->with('success', 'Halaman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $page = Page::findOrFail($id);
        
        // Hapus gambar ADMIN
        if ($page->featured_image && file_exists(public_path($page->featured_image))) {
            unlink(public_path($page->featured_image));
        }

        // Hapus gambar FRONTEND
        $gambarFrontend = 'C:/laragon/www/perumahan-web/public/' . $page->featured_image;

        if ($page->featured_image && file_exists($gambarFrontend)) {
            unlink($gambarFrontend);
        }
        
        $page->delete();

        return redirect()->route('pages.index')
            ->with('success', 'Halaman berhasil dihapus!');
    }

    public function updateOrder(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        foreach ($request->order as $index => $id) {
            Page::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    // ==================== FRONTEND ====================
    
    // Menampilkan halaman berdasarkan slug
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 'published')->firstOrFail();
        
        // Data tambahan untuk layout
        $company_name = \App\Models\Setting::get('company_name', 'SIPERUM');
        $company_logo = \App\Models\Setting::get('company_logo');
        $social_facebook = \App\Models\Setting::get('social_facebook');
        $social_instagram = \App\Models\Setting::get('social_instagram');
        $social_twitter = \App\Models\Setting::get('social_twitter');
        $social_youtube = \App\Models\Setting::get('social_youtube');
        
        return view('frontend.page', compact('page', 'company_name', 'company_logo', 
            'social_facebook', 'social_instagram', 'social_twitter', 'social_youtube'));
    }
    
    // Method tambahan untuk mendapatkan embed video
    public function getEmbedVideo($url)
    {
        if (strpos($url, 'youtube.com/watch?v=') !== false) {
            $videoId = str_replace('https://www.youtube.com/watch?v=', '', $url);
            return 'https://www.youtube.com/embed/' . $videoId;
        } elseif (strpos($url, 'youtu.be/') !== false) {
            $videoId = str_replace('https://youtu.be/', '', $url);
            return 'https://www.youtube.com/embed/' . $videoId;
        }
        return $url;
    }
}