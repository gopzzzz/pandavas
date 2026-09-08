<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\StaffRegistrationsController;
use App\Http\Controllers\ToursController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingMastersController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\UploadsController;
use App\Http\Controllers\RevenueReportsController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');


 Route::get('/page', [HomeController::class, 'page'])->name('page.list');




Route::get('/departments', [DepartmentsController::class, 'index'])
    ->name('departments.index');

Route::post('/departments', [DepartmentsController::class, 'store'])
    ->name('departments.store');

Route::put('/departments/{id}', [DepartmentsController::class, 'update'])
    ->name('departments.update');



 

Route::get('/staff-registrations', [StaffRegistrationsController::class, 'index'])
    ->name('staff_registrations.index');

Route::post('/staff-registrations', [StaffRegistrationsController::class, 'store'])
    ->name('staff_registrations.store');

Route::put('/staff-registrations/{id}', [StaffRegistrationsController::class, 'update'])
    ->name('staff_registrations.update');






Route::get('/tours', [ToursController::class, 'index'])
    ->name('tours.index');

Route::post('/tours', [ToursController::class, 'store'])
    ->name('tours.store');

Route::put('/tours/{id}', [ToursController::class, 'update'])
    ->name('tours.update');


    Route::get('/bookings', [BookingController::class, 'index'])
    ->name('bookings.index');

Route::post('/bookings', [BookingController::class, 'store'])
    ->name('bookings.store');

Route::get('/bookinglist', [BookingController::class, 'list'])
    ->name('bookings.list');

Route::put('/bookings/{id}', [BookingController::class, 'update'])
    ->name('bookings.update');

Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])
    ->name('bookings.edit');

Route::get('/booking/{id}', [BookingController::class, 'show'])
    ->name('bookings.show');





Route::get('/bookings', [BookingMastersController::class, 'index'])
    ->name('bookings.index');

Route::post('/bookings', [BookingMastersController::class, 'store'])
    ->name('bookings.store');

Route::put('/bookings/{id}', [BookingMastersController::class, 'update'])
    ->name('bookings.update');

Route::get('/bookinglist', [BookingMastersController::class, 'list'])
    ->name('bookings.list');





Route::get('/blogs', [BlogsController::class, 'index'])
    ->name('blogs.index');

Route::post('/blogs', [BlogsController::class, 'store'])
    ->name('blogs.store');

Route::put('/blogs/{id}', [BlogsController::class, 'update'])
    ->name('blogs.update');

Route::delete('/blogs/{id}', [BlogsController::class, 'destroy'])
    ->name('blogs.destroy');








Route::get('/upload-images', [UploadsController::class, 'index'])
    ->name('uploads.index');

Route::post('/upload-images', [UploadsController::class, 'store'])
    ->name('uploads.store');

Route::delete('/upload-images/{id}', [UploadsController::class, 'destroy'])
    ->name('uploads.destroy');



Route::get('/revenue-reports', [RevenueReportsController::class, 'index'])
    ->name('revenue_reports.index');

    

 

require __DIR__.'/auth.php';
