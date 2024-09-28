<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff_dashboard;
use App\Http\Controllers\Admin_dashboard;
use App\Http\Controllers\SuperAdmin_dashboard;

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// Staff dashboard routes
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('profile.edit');
        Route::patch('/', 'update')->name('profile.update');
        Route::delete('/', 'destroy')->name('profile.destroy');
    });
    
});

// Staff dashboard routes
Route::middleware(['auth', 'user-role:staff'])->group(function () {
    Route::prefix('staff')->controller(Staff_dashboard::class)->group(function () {
        Route::get('home', 'home')->name('staff.home');
        Route::get('add', 'add')->name('staff.add');
        Route::post('add_category', 'add_category')->name('staff.add_category');
        Route::delete('delete_category/{id}', 'delete_category')->name('staff.delete_category');
        Route::get('list', 'list')->name('staff.list');
    });
});

// Admin dashboard routes
Route::middleware(['auth', 'user-role:admin'])->group(function () {
    Route::prefix('admin')->controller(Admin_dashboard::class)->group(function () {
        Route::get('home', 'home')->name('admin.home');
    });
});

// Super Admin dashboard routes
Route::middleware(['auth', 'user-role:superadmin'])->group(function () {
    Route::prefix('superadmin')->controller(SuperAdmin_dashboard::class)->group(function () {
        Route::get('home', 'home')->name('superadmin.home');
    });
});



require __DIR__.'/auth.php';