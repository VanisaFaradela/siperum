<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class PengaturanController extends Controller
{
    public function index()
    {
        // Cek login dengan guard admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $admin = Auth::guard('admin')->user();
        return view('pengaturan.index', compact('admin'));
    }
    
    public function updateProfile(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:admins,email,' . Auth::guard('admin')->id(),
        ]);
        
        $admin = Auth::guard('admin')->user();
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->route('pengaturan')
            ->with('success', 'Profil berhasil diperbarui!');
    }
    
    public function updatePassword(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        
        $admin = Auth::guard('admin')->user();
        
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah!']);
        }
        
        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);
        
        return redirect()->route('pengaturan')
            ->with('success', 'Password berhasil diubah!');
    }
}