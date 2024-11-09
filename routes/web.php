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


Route::get('/patients/register', [PatientController::class, 'createPatient'])->name('patients.register');
Route::post('/patients/register', [PatientController::class, 'storePatient'])->name('patients.store');

Route::get('/patients/login', [PatientController::class, 'patientLoginForm'])->name('patients.login.form');
Route::post('/patients/login', [PatientController::class, 'patientLogin'])->name('patients.login');

Route::get('/patients/profile', [PatientController::class, 'patientProfile'])->name('patients.profile');


Route::middleware(['auth:patients'])->group(function () {
    Route::get('/patients/patient-dashboard', [PatientController::class, 'patientDashboard'])->name('patients.patient-dashboard');
    Route::get('/patients/profile', [PatientController::class, 'patientProfile'])->name('patients.profile');
    Route::get('/patients/create-appointment', [PatientController::class, 'createAppointment'])->name('patients.create-appointment');
});

Route::post('/patients/logout', [PatientController::class, 'patientLogout'])->name('patients.logout');


Route::get('/admin/register', [AdminController::class, 'createAdmin'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'storeAdmin'])->name('admin.store');

Route::get('/admin/login', [AdminController::class, 'adminLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/admin-dashboard', [AdminController::class, 'adminDashboard'])->name('admin.admin-dashboard');
});

Route::post('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');



Route::get('/doctors/register', [DoctorsController::class, 'createDoctor'])->name('doctors.register');
Route::post('/doctors/register', [DoctorsController::class, 'storeDoctor'])->name('doctors.store');

Route::get('/doctors/login', [DoctorsController::class, 'doctorLoginForm'])->name('doctors.login.form');
Route::post('/doctors/login', [DoctorsController::class, 'doctorLogin'])->name('doctors.login');

Route::middleware(['auth:doctors'])->group(function () {
    Route::get('/doctors/doctor-dashboard', [DoctorsController::class, 'doctorDashboard'])->name('doctors.doctor-dashboard');
    Route::get('/doctors/profile', [DoctorsController::class, 'doctorProfile'])->name('doctors.profile');
});

Route::post('/doctors/logout', [DoctorsController::class, 'doctorLogout'])->name('doctors.logout');






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


