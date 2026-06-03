<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Cluster;
use App\Models\TipeRumah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $promos = Promo::with(['cluster', 'tipeRumah'])->latest()->paginate(10);
        $totalPromo = Promo::count();
        $totalActive = Promo::where('status', 'active')->count();
        $totalExpired = Promo::where('status', 'expired')->count();
        
        return view('promo.index', compact('promos', 'totalPromo', 'totalActive', 'totalExpired'));
    }

    public function create()
    {
        $clusters = Cluster::all();
        $tipeRumahs = TipeRumah::with('cluster')->get();
        return view('promo.create', compact('clusters', 'tipeRumahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_promo' => 'required|string|max:255',
            'badge' => 'nullable|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cluster_id' => 'required|exists:clusters,id',
            'harga_awal' => 'nullable|numeric',
            'harga_promo' => 'required|numeric',
            'diskon' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:active,expired,coming_soon',
            'tipe_rumah_id' => 'array|exists:tipe_rumah,id',
            'deskripsi' => 'nullable|string'
        ]);

        $data = $request->except('tipe_rumah_id', 'gambar');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('promo', $filename, 'public');
            $data['gambar'] = '/storage/' . $path;
        }

        $promo = Promo::create($data);

        if ($request->has('tipe_rumah_id') && !empty($request->tipe_rumah_id)) {
            $promo->tipeRumah()->attach($request->tipe_rumah_id);
        }

        return redirect()->route('promo.index')->with('success', 'Promo berhasil ditambahkan');
    }

    public function edit($id)
    {
        $promo = Promo::with('tipeRumah')->findOrFail($id);
        $clusters = Cluster::all();
        $tipeRumahs = TipeRumah::with('cluster')->get();
        $selectedTipes = $promo->tipeRumah->pluck('id')->toArray();
        
        return view('promo.edit', compact('promo', 'clusters', 'tipeRumahs', 'selectedTipes'));
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);
        
        $request->validate([
            'judul_promo' => 'required|string|max:255',
            'badge' => 'nullable|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cluster_id' => 'required|exists:clusters,id',
            'harga_awal' => 'nullable|numeric',
            'harga_promo' => 'required|numeric',
            'diskon' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:active,expired,coming_soon',
            'tipe_rumah_id' => 'array|exists:tipe_rumah,id',
            'deskripsi' => 'nullable|string'
        ]);

        $data = $request->except('tipe_rumah_id', 'gambar');

        if ($request->hasFile('gambar')) {
            if ($promo->gambar) {
                $oldPath = str_replace('/storage/', '', $promo->gambar);
                Storage::disk('public')->delete($oldPath);
            }
            
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('promo', $filename, 'public');
            $data['gambar'] = '/storage/' . $path;
        }

        $promo->update($data);
        $promo->tipeRumah()->sync($request->tipe_rumah_id ?? []);

        return redirect()->route('promo.index')->with('success', 'Promo berhasil diupdate');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        
        if ($promo->gambar) {
            $path = str_replace('/storage/', '', $promo->gambar);
            Storage::disk('public')->delete($path);
        }
        
        $promo->tipeRumah()->detach();
        $promo->delete();

        return redirect()->route('promo.index')->with('success', 'Promo berhasil dihapus');
    }

    public function getTipeRumah(Request $request)
    {
        $tipeRumahs = TipeRumah::where('cluster_id', $request->cluster_id)->get();
        return response()->json($tipeRumahs);
    }
}