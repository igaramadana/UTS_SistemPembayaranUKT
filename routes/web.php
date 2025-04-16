<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

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


Route::get('/mahasiswa', function () {
    return view('mahasiswa.index');
});

Route::group(['prefix' => 'role'], function () {
    Route::get('/', [RoleController::class, 'index'])->name('role.index');
    Route::get('/list', [RoleController::class, 'list'])->name('role.list');
    Route::get('/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/store', [RoleController::class, 'store'])->name('role.store');
    // Show Detail
    Route::get('/detail/{id}', [RoleController::class, 'show'])->name('role.show');
    // Edit
    Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/{id}/update', [RoleController::class, 'update'])->name('role.update');
    // Delete
    Route::get('/{id}/delete', [RoleController::class, 'confirm'])->name('role.confirm');
    Route::delete('/{id}/delete', [RoleController::class, 'delete'])->name('role.delete');
});
