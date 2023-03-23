<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::prefix('tree')->group(function () {
    Route::get('/create', [\App\Http\Controllers\TreeController::class, 'create'])->name('tree.create');
    Route::post('/store', [\App\Http\Controllers\TreeController::class, 'store'])->name('tree.store');
    Route::get('/auto-create', [\App\Http\Controllers\TreeController::class, 'autoCreate'])->name('tree.autocreate');
    Route::post('/generate', [\App\Http\Controllers\TreeController::class, 'generate'])->name('tree.generate');
    Route::get('/show', [\App\Http\Controllers\TreeController::class, 'show'])->name('tree.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
