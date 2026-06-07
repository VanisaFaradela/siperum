<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\TipeRumahController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PromoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================
// ROUTE LOGIN
// ============================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================
// ROUTE RESET PASSWORD
// ============================================

// Halaman reset password (tanpa token) - LANGSUNG buat token dan redirect
Route::get('/reset-password', function () {
    $token = Str::random(60);

    // Tidak menyimpan email lagi
    Cache::put('reset_' . $token, true, 900);

    return redirect('/reset-password/' . $token);
});

// Halaman form reset password (dengan token)
Route::get('/reset-password/{token}', function ($token) {

    if (!Cache::has('reset_' . $token)) {
        return redirect('/login')->withErrors([
            'Link reset sudah kadaluarsa atau tidak valid'
        ]);
    }

    return view('reset-password', [
        'token' => $token
    ]);
});

// Proses reset password (submit form)
Route::post('/reset-password/proses', function (Request $request) {

    $request->validate([
        'email' => 'required|email|exists:admins,email',
        'password' => 'required|min:6|confirmed',
        'token' => 'required'
    ]);

    if (!Cache::has('reset_' . $request->token)) {
        return back()->withErrors([
            'Link reset sudah kadaluarsa.'
        ]);
    }

    DB::table('admins')
        ->where('email', $request->email)
        ->update([
            'password' => Hash::make($request->password)
        ]);

    Cache::forget('reset_' . $request->token);

    return redirect('/login')
        ->with('status', 'Password berhasil diubah.');
});

// ============================================
// ROUTE DASHBOARD
// ============================================
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ============================================
// CRUD CLUSTER - MENGGUNAKAN PARAMETER {cluster} (Route Model Binding)
// ============================================
Route::resource('cluster', ClusterController::class);
Route::get('/media/cluster/{file}', function ($file) {

    $path = '/home/u143856011/shared/uploads/cluster/' . $file;

    abort_unless(file_exists($path), 404);

    return response()->file($path);

})->where('file', '.*')->name('media.cluster');

// ============================================
// CRUD TIPE RUMAH
// ============================================
Route::resource('tipe-rumah', TipeRumahController::class);
Route::get('/media/tipe-rumah/{file}', function ($file) {

    $path = '/home/u143856011/shared/uploads/tipe-rumah/' . $file;

    abort_unless(file_exists($path), 404);

    return response()->file($path);

})->where('file', '.*')->name('media.tipe-rumah');

// ============================================
// CRUD BERITA
// ============================================
Route::resource('berita', BeritaController::class);
Route::get('/media/berita/{file}', function ($file) {

    $path = '/home/u143856011/shared/uploads/berita/' . $file;

    abort_unless(file_exists($path), 404);

    return response()->file($path);

})->where('file', '.*')->name('media.berita');

// ============================================
// CRUD GALERI
// ============================================
Route::resource('galeri', GaleriController::class);
Route::post('/galeri/update-order', [GaleriController::class, 'updateOrder'])->name('galeri.update-order');
Route::get('/media/galeri/{file}', function ($file) {

    $path = '/home/u143856011/shared/uploads/galeri/' . $file;

    abort_unless(file_exists($path), 404);

    return response()->file($path);

})->where('file', '.*')->name('media.galeri');

// ============================================
// CRUD KONTAK
// ============================================
Route::resource('kontak', KontakController::class);
Route::post('/kontak/bulk-delete', [KontakController::class, 'bulkDelete'])->name('kontak.bulk-delete');
Route::patch('/kontak/{id}/toggle-status', [KontakController::class, 'toggleStatus'])->name('kontak.toggle-status');

// ============================================
// CRUD MESSAGE
// ============================================
Route::resource('message', MessageController::class);
Route::post('/message/bulk-delete', [MessageController::class, 'bulkDelete'])->name('message.bulk-delete');

// ============================================
// PENGATURAN ADMIN
// ============================================
Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
Route::put('/pengaturan/profile', [PengaturanController::class, 'updateProfile'])->name('pengaturan.update-profile');
Route::put('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.update-password');

// ============================================
// MANAJEMEN HALAMAN (PAGES)
// ============================================
Route::resource('pages', PageController::class);
Route::post('/pages/update-order', [PageController::class, 'updateOrder'])->name('pages.update-order');
Route::get('/media/pages/{file}', function ($file) {

    $path = '/home/u143856011/shared/uploads/pages/' . $file;

    abort_unless(file_exists($path), 404);

    return response()->file($path);

})->where('file', '.*')->name('media.pages');

// ============================================
// TENTANG KAMI (ADMIN EDIT)
// ============================================
Route::get('/tentang-kami/edit', [TentangKamiController::class, 'edit'])->name('tentang-kami.edit');
Route::put('/tentang-kami/update', [TentangKamiController::class, 'update'])->name('tentang-kami.update');

// ============================================
// ROUTE TEAM (STRUKTUR ORGANISASI)
// ============================================
Route::prefix('admin')->group(function () {
    Route::resource('team', TeamController::class);
    Route::patch('/team/{id}/toggle-status', [TeamController::class, 'toggleStatus'])->name('team.toggle-status');
    Route::post('/team/reorder', [TeamController::class, 'updateOrder'])->name('team.reorder');
});
Route::get('/media/team/{file}', function ($file) {

    $path = '/home/u143856011/shared/uploads/team/' . $file;

    abort_unless(file_exists($path), 404);

    return response()->file($path);

})->where('file', '.*')->name('media.team');

// ============================================
// PROMO
// ============================================
Route::resource('promo', PromoController::class);
Route::get('/get-tipe-rumah', [PromoController::class, 'getTipeRumah'])->name('get-tipe-rumah');

// ============================================
// ROUTE UNTUK MODAL PROMO (SESSION)
// ============================================
Route::post('/promo-modal-seen-berita', function() {
    session(['promo_closed_berita' => true]);
    return response()->json(['success' => true]);
})->name('promo.modal.seen.berita');

Route::post('/promo-modal-seen-tipe', function() {
    session(['promo_closed_tipe' => true]);
    return response()->json(['success' => true]);
})->name('promo.modal.seen.tipe');