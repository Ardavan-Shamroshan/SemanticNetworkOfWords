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
    if (auth()->check()) {
        if (auth()->user()->user_type == 'admin')
            return to_route('admin.dashboard');
        elseif (auth()->user()->user_type == 'user')
            return to_route('dashboard');
        else
            return view('welcome');
    } else
        return to_route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user:user'])->name('dashboard');

Route::middleware(['auth', 'verified', 'user:admin'])->prefix('admin')->as('admin.')->group(function () {
    // admin dashboard
    Route::get('dashboard', static function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // word
    Route::resource('word', \App\Http\Controllers\Admin\DashboardController::class);
    Route::get('word/{word}/semantics', [\App\Http\Controllers\Admin\DashboardController::class, 'semantics'])->name('word.semantic.index');

    Route::resource('register-admin-user', \App\Http\Controllers\Admin\RegisterAdminUserController::class)
        ->parameters(['register-admin-user' => 'admin'])
        ->only(['index', 'store', 'destroy']);
});

Route::get('semantic-network', [\App\Http\Controllers\DashboardController::class, 'index'])->name('semantic-network.index');
Route::get('semantic-network/create', [\App\Http\Controllers\DashboardController::class, 'create'])->name('semantic-network.create');
Route::post('semantic-network/{word?}', [\App\Http\Controllers\DashboardController::class, 'store'])->name('semantic-network.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


