<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff_dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('staff/home', [Staff_dashboard::class, 'home']);

Route::get('staff/add', [Staff_dashboard::class, 'add']);

Route::post('staff/add_category', [Staff_dashboard::class, 'add_category'])->name('staff.add_category');
Route::delete('staff/delete_category/{id}', [Staff_dashboard::class, 'delete_category'])->name('staff.delete_category');

Route::get('staff/list', [Staff_dashboard::class, 'list']);

Route::get('staff/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
});

require __DIR__.'/auth.php';
