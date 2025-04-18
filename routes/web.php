<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OnarController;
use App\Http\Controllers\TalakController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PenilaianRuanganController;

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

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/login', [MainController::class, 'login'])->name('login');
Route::post('/login', [MainController::class, 'loginPost'])->name('login.post');

Route::post('/filter-mingguan', [MainController::class, 'filterMingguan'])->name('filter-mingguan');
Route::post('/rekap-mingguan', [MainController::class, 'rekapMingguan'])->name('rekap-mingguan');
Route::post('/rekap-bulanan', [MainController::class, 'rekapBulanan'])->name('rekap-bulanan');
Route::post('/rekap-triwulan', [MainController::class, 'rekapTriwulan'])->name('rekap-triwulan');

Route::get('/talak', [TalakController::class, 'index'])->name('talak.index');
Route::get('/penilaian-talak/create/{id}', [TalakController::class, 'createPenilaian'])->name('penilaian-talak.create');
Route::post('/penilaian-talak/store/{id}', [TalakController::class, 'storePenilaian'])->name('penilaian-talak.store');

Route::get('/onar', [OnarController::class, 'index'])->name('onar.index');
Route::get('/penilaian-onar/create/{id}', [OnarController::class, 'createPenilaian'])->name('penilaian-onar.create');
Route::post('/penilaian-onar/store/{id}', [OnarController::class, 'storePenilaian'])->name('penilaian-onar.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [MainController::class, 'logout'])->name('logout');
    Route::get('/rekap', [MainController::class, 'rekap'])->name('rekap');

    Route::get('/penilaian-talak', [TalakController::class, 'indexPenilaian'])->name('penilaian-talak');
    Route::get('/penilaian-onar', [OnarController::class, 'indexPenilaian'])->name('penilaian-onar');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/', [PegawaiController::class, 'index'])->name('index');
        Route::get('/create', [PegawaiController::class, 'create'])->name('create');
        Route::post('/store', [PegawaiController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PegawaiController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PegawaiController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [PegawaiController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('ruangan')->name('ruangan.')->group(function () {
        Route::get('/', [RuanganController::class, 'index'])->name('index');
        Route::get('/create', [RuanganController::class, 'create'])->name('create');
        Route::post('/store', [RuanganController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RuanganController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [RuanganController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [RuanganController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/create', [PenilaianController::class, 'create'])->name('create');
        Route::post('/store', [PenilaianController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PenilaianController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PenilaianController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [PenilaianController::class, 'destroy'])->name('destroy');
        Route::post('/list-pegawai-belum-dinilai', [PenilaianController::class, 'pegawaiBelumDinilaiMingguTertentu'])->name('list-pegawai-belum-dinilai');

        Route::prefix('ruangan')->name('ruangan.')->group(function () {
            Route::get('/', [PenilaianRuanganController::class, 'index'])->name('index');
            Route::get('/create', [PenilaianRuanganController::class, 'create'])->name('create');
            Route::post('/store', [PenilaianRuanganController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [PenilaianRuanganController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [PenilaianRuanganController::class, 'update'])->name('update');
            Route::get('/destroy/{id}', [PenilaianRuanganController::class, 'destroy'])->name('destroy');
            Route::post('/list-ruangan-belum-dinilai', [PenilaianRuanganController::class, 'ruanganBelumDinilaiMingguTertentu'])->name('list-ruangan-belum-dinilai');
        });
    });

    Route::prefix('talak')->name('talak.')->group(function () {
        Route::get('/create', [TalakController::class, 'create'])->name('create');
        Route::post('/store', [TalakController::class, 'store'])->name('store');
        Route::get('/show/{id}', [TalakController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [TalakController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [TalakController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [TalakController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('onar')->name('onar.')->group(function () {
        Route::get('/create', [OnarController::class, 'create'])->name('create');
        Route::post('/store', [OnarController::class, 'store'])->name('store');
        Route::get('/show/{id}', [OnarController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [OnarController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [OnarController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [OnarController::class, 'destroy'])->name('destroy');
    });
});
