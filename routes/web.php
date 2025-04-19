<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Foundation\Console\RouteListCommand;

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

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/avv', function () {
    return view('routefooter');
})->name('avv');

Route::get('/mahasiswa', function () {
    return view('mahasiswa.index');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::middleware(['auth', 'role:ADM'])->prefix('admin')->group(function () {
    // Role
    Route::group(['prefix' => 'role'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::get('/list', [RoleController::class, 'list'])->name('role.list');
        Route::post('/store', [RoleController::class, 'store'])->name('role.store');
        // Show Detail
        Route::get('/detail/{id}', [RoleController::class, 'show'])->name('role.show');
        // Edit
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/{id}/update', [RoleController::class, 'update'])->name('role.update');
        // Delete
        Route::get('/{id}/confirm-delete', [RoleController::class, 'confirm'])->name('role.confirm');
        Route::delete('/{id}/delete', [RoleController::class, 'delete'])->name('role.delete');
    });

    // Jurusan
    Route::group(['prefix' => 'jurusan'], function () {
        Route::get('/', [JurusanController::class, 'index'])->name('jurusan.index');
        Route::get('/list', [JurusanController::class, 'list'])->name('jurusan.list');
        Route::post('/store', [JurusanController::class, 'store'])->name('jurusan.store');
        // Show Detail
        Route::get('/detail/{id}', [JurusanController::class, 'show'])->name('jurusan.show');
        // Edit
        Route::get('/{id}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
        Route::put('/{id}/update', [JurusanController::class, 'update'])->name('jurusan.update');
        // Delete
        Route::get('/{id}/delete', [JurusanController::class, 'confirm'])->name('jurusan.confirm');
        Route::delete('/{id}/delete', [JurusanController::class, 'delete'])->name('jurusan.delete');
    });

    // Program studi
    Route::group(['prefix' => 'prodi'], function () {
        Route::get('/', [ProdiController::class, 'index'])->name('prodi.index');
        Route::get('/list', [ProdiController::class, 'list'])->name('prodi.list');
        Route::post('/store', [ProdiController::class, 'store'])->name('prodi.store');
        // Show Detail
        Route::get('/detail/{id}', [ProdiController::class, 'show'])->name('prodi.show');
        // Edit Data
        Route::get('/{id}/edit', [ProdiController::class, 'edit'])->name('prodi.edit');
        Route::put('/{id}/update', [ProdiController::class, 'update'])->name('prodi.update');
        // Delete
        Route::get('/{id}/delete', [ProdiController::class, 'confirm'])->name('prodi.confirm');
        Route::delete('/{id}/delete', [ProdiController::class, 'delete'])->name('prodi.delete');
    });

    // User
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/list', [UserController::class, 'list'])->name('user.list');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        // show detail
        Route::get('/detail/{id}', [UserController::class, 'show'])->name('user.show');
        // Delete
        Route::get('/{id}/delete', [UserController::class, 'confirm'])->name('user.confirm');
        Route::delete('/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
    });

    // Mahasiswa
    Route::group(['prefix' => 'mahasiswa'], function () {
        Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/list', [MahasiswaController::class, 'list'])->name('mahasiswa.list');
        Route::post('/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
        // show detail
        Route::get('/detail/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    });

    // Admin
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/list', [AdminController::class, 'list'])->name('admin.list');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        // Show Detail
        Route::get('/detail/{id}', [AdminController::class, 'show'])->name('admin.show');
    });
});


Route::middleware(['auth', 'role:MHS'])->prefix('mahasiswa')->group(function () {
    Route::get('/', function () {
        return view('routefooter');
    })->name('testing');
});
