<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KontakController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $search = $request->input('search');
        $hasPerusahaan = $request->input('has_perusahaan');
        $status = $request->input('status');

        $kontak = Kontak::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('perusahaan', 'like', "%{$search}%")
                             ->orWhere('telepon', 'like', "%{$search}%");
            })
            ->when($hasPerusahaan == 'yes', function ($query) {
                return $query->whereNotNull('perusahaan');
            })
            ->when($hasPerusahaan == 'no', function ($query) {
                return $query->whereNull('perusahaan');
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalKontak = Kontak::count();
        $totalPerusahaan = Kontak::whereNotNull('perusahaan')->count();
        $totalEmail = Kontak::whereNotNull('email')->count();
        $totalTelepon = Kontak::whereNotNull('telepon')->count();
        $totalAktif = Kontak::where('status', 'aktif')->count();
        $totalNonaktif = Kontak::where('status', 'nonaktif')->count();

        return view('kontak.index', compact(
            'kontak', 
            'totalKontak', 
            'totalPerusahaan', 
            'totalEmail', 
            'totalTelepon',
            'totalAktif',
            'totalNonaktif'
        ));
    }

    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        return view('kontak.create');
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'perusahaan' => 'nullable|string|max:255',
            'status' => 'nullable|in:aktif,nonaktif',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
        ]);

        $data = $request->all();
        if (empty($data['status'])) {
            $data['status'] = 'aktif';
        }

        Kontak::create($data);

        return redirect()->route('kontak.index')
            ->with('success', 'Kontak berhasil ditambahkan!');
    }

    public function show($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $kontak = Kontak::findOrFail($id);
        
        return view('kontak.show', compact('kontak'));
    }

    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $kontak = Kontak::findOrFail($id);
        
        return view('kontak.edit', compact('kontak'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $kontak = Kontak::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'perusahaan' => 'nullable|string|max:255',
            'status' => 'nullable|in:aktif,nonaktif',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
        ]);

        $kontak->update($request->all());

        return redirect()->route('kontak.index')
            ->with('success', 'Kontak berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $kontak = Kontak::findOrFail($id);
        $kontak->delete();

        return redirect()->route('kontak.index')
            ->with('success', 'Kontak berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $kontak = Kontak::findOrFail($id);
        
        if ($kontak->status == 'aktif') {
            $kontak->update(['status' => 'nonaktif']);
            $message = 'Kontak berhasil dinonaktifkan!';
        } else {
            $kontak->update(['status' => 'aktif']);
            $message = 'Kontak berhasil diaktifkan!';
        }

        return redirect()->back()->with('success', $message);
    }
}