<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/patients/register', [PatientController::class, 'create'])->name('patients.register');
Route::post('/patients/register', [PatientController::class, 'store'])->name('patients.store');

Route::get('/admin/register', [AdminController::class, 'create'])->name('admins.create');
Route::post('/admin/register', [AdminController::class, 'store'])->name('admins.store');

Route::get('/doctor/register', [DoctorsController::class, 'create'])->name('doctors.create');
Route::post('/doctor/register', [DoctorsController::class, 'store'])->name('doctors.store');






// Route::get('admin/register', [AdminController::class, 'create'])->name('admin.register.form'); // Registration form
// Route::post('admin/register', [AdminController::class, 'register'])->name('admin.register'); // Register admin

// Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login.form'); // Login form
// Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login'); // Login admin

// Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout'); // Logout admin


// Route::middleware(['auth:admin'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');
// });


