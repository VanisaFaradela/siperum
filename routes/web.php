<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\TipeRumahController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PengaturanWebsiteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TentangKamiController;
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
// ROUTE DASHBOARD
// ============================================
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ============================================
// CRUD CLUSTER - MENGGUNAKAN PARAMETER {cluster} (Route Model Binding)
// ============================================
Route::resource('cluster', ClusterController::class);

// ============================================
// CRUD TIPE RUMAH
// ============================================
Route::resource('tipe-rumah', TipeRumahController::class);

// ============================================
// CRUD BERITA
// ============================================
Route::resource('berita', BeritaController::class);

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
Route::post('/kontak/{kontak}/reply', [KontakController::class, 'reply'])->name('kontak.reply');
Route::post('/kontak/bulk-delete', [KontakController::class, 'bulkDelete'])->name('kontak.bulk-delete');
Route::patch('/kontak/{id}/toggle-status', [KontakController::class, 'toggleStatus'])->name('kontak.toggle-status');

// ============================================
// CRUD MESSAGE
// ============================================
Route::resource('message', MessageController::class);
Route::post('/message/{message}/reply', [MessageController::class, 'reply'])->name('message.reply');
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

// ============================================
// PENGATURAN WEBSITE
// ============================================
Route::prefix('pengaturan-website')->group(function () {
    Route::get('/', [PengaturanWebsiteController::class, 'index'])->name('pengaturan-website.index');
    Route::put('/website', [PengaturanWebsiteController::class, 'updateWebsite'])->name('pengaturan-website.website');
    Route::put('/owner', [PengaturanWebsiteController::class, 'updateOwner'])->name('pengaturan-website.owner');
    Route::put('/kontak', [PengaturanWebsiteController::class, 'updateKontak'])->name('pengaturan-website.kontak');
    Route::put('/sosial', [PengaturanWebsiteController::class, 'updateSosialMedia'])->name('pengaturan-website.sosial');
    Route::put('/tentang', [PengaturanWebsiteController::class, 'updateTentangKami'])->name('pengaturan-website.tentang');
    Route::put('/hero', [PengaturanWebsiteController::class, 'updateHero'])->name('pengaturan-website.hero');
    Route::put('/footer', [PengaturanWebsiteController::class, 'updateFooter'])->name('pengaturan-website.footer');
});

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

// ============================================
// FRONTEND PAGES (HARUS DI PALING BAWAH)
// ============================================
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show')->where('slug', '.*');