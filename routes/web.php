<?php

use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\TambahBarangController;
use App\Http\Controllers\TempImagesController;
use App\Http\Controllers\AksiController;
use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    // Aplikasi
    Route::get('/pengaturan-aplikasi', [AplikasiController::class, 'index'])->name('pengaturan-apikasi.index');
    Route::post('/pengaturan-apllikasi/update', [AplikasiController::class, 'update'])->name('pengaturan-aplikasi.update');

    // Temp Images
    Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/change-status/{id}', [UserController::class, 'changeStatus'])->name('change-status');


    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('users/update-password/{id}', [ProfileController::class, 'updatePassword'])->name('users.update-password');

    // Group
    Route::get('/group', [GroupController::class, 'index'])->name('group.index');
    Route::post('/group', [GroupController::class, 'store'])->name('group.store');
    Route::delete('/group/{id}', [GroupController::class, 'destroy'])->name('group.delete');

    // Section
    Route::get('/aksi', [AksiController::class, 'index'])->name('aksi.index');

    // Menu
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu/create-section', [MenuController::class, 'create_section'])->name('menu.create-section');
    Route::post('/menu', [MenuController::class, 'create_menu'])->name('menu.store');
    Route::get('/menu/detail-section/{id}', [MenuController::class, 'detail_section']);
    Route::get('/menu/detail-menu/{id}', [MenuController::class, 'detail_menu']);
    Route::put('/menu/update-section/{id}', [MenuController::class, 'update_section'])->name('menu.update-section');
    Route::put('/menu/update-menu/{id}', [MenuController::class, 'update_menu'])->name('menu.update-menu');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy_menu'])->name('menu.delete');
    Route::delete('/menu/delete-section/{id}', [MenuController::class, 'destroy_section'])->name('menu.delete-section');

    // Permission
    Route::get('permission/data-akses/{id}', [PermissionController::class, 'data_akses'])->name('permission.data-akses');
    Route::post('permission/data-akses/edit_akses', [PermissionController::class, 'edit_akses'])->name('permission.edit-akses');
    Route::post('permission/data-akses/all_access', [PermissionController::class, 'all_access'])->name('permission.all-akses');

    // ruangan
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::get('/ruangan/{id}', [RuanganController::class, 'show'])->name('ruangan.show');
    Route::put('/ruangan/{id}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy'])->name('ruangan.delete');
    Route::post('/ruangan-status', [RuanganController::class, 'statusRuangan'])->name('ruangan.status');

    // kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');
    Route::post('/kategori-status', [KategoriController::class, 'statusKategori'])->name('kategori.status');

    // Barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.delete');
    Route::post('/barang-status', [BarangController::class, 'statusBarang'])->name('barang.status');
    Route::get('/barang/detail/data/{id}', [BarangController::class, 'detail'])->name('barang.detail');
    Route::post('/barang/verified/{id}', [BarangController::class, 'verified'])->name('barang.verified');
    Route::post('/barang/verified-all', [BarangController::class, 'verifiedAll'])->name('barang.verified-all');

    // Barang Keluar
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
    Route::post('/barang-keluar/{id}', [BarangKeluarController::class, 'createKeluar'])->name('barang-keluar.create');
    Route::post('/barang-keluar/terima/{id}', [BarangKeluarController::class, 'terima'])->name('barang-keluar.terima');
    Route::post('/barang-keluar/tolak/{id}', [BarangKeluarController::class, 'tolak'])->name('keluar.tolak');

    // Asset
    Route::get('/inventaris', [AssetController::class, 'index'])->name('inventaris.index');
    Route::get('/inventaris/ruangan/{id}', [AssetController::class, 'detail'])->name('inventaris.ruangan');
    route::get('/inventaris/barang/edit/{id}', [AssetController::class, 'edit'])->name('inventaris.barang-edit');
    Route::put('/inventaris/barang/{id}', [AssetController::class, 'update'])->name('inventaris.update-barang');
    Route::get('/getDataFor/{id}', [AssetController::class, 'getDataFor'])->name('barang.getDataFor');

    // Mutasi
    Route::post('/mutasi-barang/{id}', [MutasiController::class, 'createMutasi'])->name('mutasi-barang.create');
    Route::get('/mutasi-barang', [MutasiController::class, 'index'])->name('mutasi-barang.index');
    Route::post('/mutasi/terima/{id}', [MutasiController::class, 'terima'])->name('mutasi-barang.terima');
    Route::post('/mutasi/tolak/{id}', [MutasiController::class, 'tolak'])->name('mutasi-barang.tolak');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan-excel/{type}/{date_start}/{date_end}', [LaporanController::class, 'download_excel'])->name('laporan.excel');
});
