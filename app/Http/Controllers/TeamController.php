<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $search = $request->input('search');
        $status = $request->input('status');

        $team = Team::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhere('jabatan', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('urutan', 'asc')
            ->paginate(10);

        $totalTeam = Team::count();
        $totalAktif = Team::where('status', 'aktif')->count();
        $totalNonaktif = Team::where('status', 'nonaktif')->count();

        return view('team.index', compact('team', 'totalTeam', 'totalAktif', 'totalNonaktif'));
    }

    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        return view('team.create');
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $data = $request->except('foto');
        
        // Set urutan
        $maxUrutan = Team::max('urutan');
        $data['urutan'] = $maxUrutan + 1;

        // Upload foto
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            $namaFile = time() . '_team_' . preg_replace(
                '/[^a-zA-Z0-9._-]/',
                '',
                $file->getClientOriginalName()
            );

            $tujuanShared = '/home/u143856011/shared/uploads/team';

            if (!file_exists($tujuanShared)) {
                mkdir($tujuanShared, 0775, true);
            }

            $file->move($tujuanShared, $namaFile);

            $data['foto'] = 'uploads/team/' . $namaFile;
        }

        Team::create($data);

        return redirect()->route('team.index')
            ->with('success', 'Anggota tim berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $team = Team::findOrFail($id);
        
        return view('team.edit', compact('team'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $team = Team::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $data = $request->except('foto');

        // Hapus foto jika dicentang
        if ($request->has('hapus_foto')) {

            if ($team->foto) {

                $filePath =
                    '/home/u143856011/shared/uploads/team/' .
                    basename($team->foto);

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $data['foto'] = null;
        }

        // Upload foto baru
        if ($request->hasFile('foto')) {

            if ($team->foto) {

                $fileLama =
                    '/home/u143856011/shared/uploads/team/' .
                    basename($team->foto);

                if (file_exists($fileLama)) {
                    unlink($fileLama);
                }
            }

            $file = $request->file('foto');

            $namaFile = time() . '_team_' . preg_replace(
                '/[^a-zA-Z0-9._-]/',
                '',
                $file->getClientOriginalName()
            );

            $tujuanShared = '/home/u143856011/shared/uploads/team';

            if (!file_exists($tujuanShared)) {
                mkdir($tujuanShared, 0775, true);
            }

            $file->move($tujuanShared, $namaFile);

            $data['foto'] = 'uploads/team/' . $namaFile;
        }

        $team->update($data);

        return redirect()->route('team.index')
            ->with('success', 'Anggota tim berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $team = Team::findOrFail($id);
        
        if ($team->foto) {

            $filePath =
                '/home/u143856011/shared/uploads/team/' .
                basename($team->foto);

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        $team->delete();

        return redirect()->route('team.index')
            ->with('success', 'Anggota tim berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $team = Team::findOrFail($id);
        
        if ($team->status == 'aktif') {
            $team->update(['status' => 'nonaktif']);
            $message = 'Anggota tim dinonaktifkan!';
        } else {
            $team->update(['status' => 'aktif']);
            $message = 'Anggota tim diaktifkan!';
        }

        return redirect()->back()->with('success', $message);
    }

    public function updateOrder(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['success' => false], 403);
        }
        
        foreach ($request->order as $index => $id) {
            Team::where('id', $id)->update(['urutan' => $index + 1]);
        }
        
        return response()->json(['success' => true]);
    }
}