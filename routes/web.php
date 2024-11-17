<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
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

Route::get('/login', [MainController::class, 'login'])->name('login');
Route::post('/login', [MainController::class, 'loginPost'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::get('/logout', [MainController::class, 'logout'])->name('logout');

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

    Route::prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/create', [PenilaianController::class, 'create'])->name('create');
        Route::post('/store', [PenilaianController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PenilaianController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PenilaianController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [PenilaianController::class, 'destroy'])->name('destroy');

        Route::prefix('ruangan')->name('ruangan.')->group(function () {
            Route::get('/', [PenilaianRuanganController::class, 'index'])->name('index');
            Route::get('/create', [PenilaianRuanganController::class, 'create'])->name('create');
            Route::post('/store', [PenilaianRuanganController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [PenilaianRuanganController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [PenilaianRuanganController::class, 'update'])->name('update');
            Route::get('/destroy/{id}', [PenilaianRuanganController::class, 'destroy'])->name('destroy');
        });
    });
});
