<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuSyncController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ResourceSyncController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('setting')->name('setting.')->middleware(['auth','verified'])->group(function () {
    Route::resource('resources', ResourceController::class)->only(['index','update']);
    Route::post('resources/sync', [ResourceSyncController::class, 'store'])->name('resources.sync');

    Route::resource('roles', RoleController::class)->only(['index','edit','update']);

    Route::resource('menus', MenuController::class);
    Route::post('menus/sync', [MenuSyncController::class, 'store'])->name('menus.sync');
});

require __DIR__.'/auth.php';
