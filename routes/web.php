<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\EmergencyContactController;
use App\Http\Controllers\TechSupportController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PatientManagementController;
use App\Http\Controllers\DoctorManagementController;


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

// Forgot Password Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Reset Password Routes
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('patients.password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('patients.password.update');



Route::middleware(['auth:patients'])->group(function () {
    Route::get('/patients/patient-dashboard', [PatientController::class, 'patientDashboard'])->name('patients.patient-dashboard');
    Route::get('/patients/profile', [PatientController::class, 'patientProfile'])->name('patients.profile');
    Route::get('/patient/edit-profile', [PatientController::class, 'editPatientProfile'])->name('patients.edit-profile');
    Route::put('/patient/edit-profile', [EmergencyContactController::class, 'updateEmergencyContact'])->name('patients.edit-contact');
    Route::put('/patient/update-profile', [PatientController::class, 'updatePatientProfile'])->name('patients.update-profile');
    
    Route::get('/patients/create-appointment', [AppointmentController::class, 'createAppointment'])->name('patients.create-appointment');
    Route::post('/patients/store-appointment', [AppointmentController::class, 'storeAppointment'])->name('patients.store-appointment');
    Route::get('/my-appointments', [PatientController::class, 'myAppointments'])->name('patients.my-appointments');
    Route::post('/my-appointments/{id}/cancel', [PatientController::class, 'cancelAppointment'])->name('patients.cancel-appointment');

    Route::get('/patients/tech-support', [PatientController::class, 'techSupport'])->name('patients.tech-support');
    Route::post('/patients/submit-tech-support', [TechSupportController::class, 'submitTechSupport'])->name('patients.submit-tech-support');
    


});

Route::post('/patients/logout', [PatientController::class, 'patientLogout'])->name('patients.logout');


Route::get('/admin/register', [AdminController::class, 'createAdmin'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'storeAdmin'])->name('admin.store');

Route::get('/admin/login', [AdminController::class, 'adminLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.update-profile');

    Route::get('/admin/admin-dashboard', [AdminController::class, 'adminDashboard'])->name('admin.admin-dashboard');

    Route::get('/admin/appointments/create', [AdminController::class, 'createAppointment'])->name('admin.appointments.create');
    Route::post('/admin/appointments/store', [AdminController::class, 'storeAppointment'])->name('admin.appointments.store');

    Route::get('/admin/patients', [PatientManagementController::class, 'index'])->name('admin.patients.index');
    Route::get('/admin/patients/{id}/edit', [PatientManagementController::class, 'edit'])->name('admin.patients.edit');
    Route::put('/admin/patients/{id}', [PatientManagementController::class, 'update'])->name('admin.patients.update');

    Route::get('/admin/doctors', [DoctorManagementController::class, 'index'])->name('admin.doctors.index');
    Route::get('/admin/doctors/{id}/edit', [DoctorManagementController::class, 'edit'])->name('admin.doctors.edit');
    Route::put('/admin/doctors/{id}', [DoctorManagementController::class, 'update'])->name('admin.doctors.update');

    Route::get('/admin/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::get('/admin/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('admin.appointments.edit');
    Route::put('/admin/appointments/{appointment}', [AppointmentController::class, 'update'])->name('admin.appointments.update');
    Route::delete('/admin/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');


});

Route::post('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');



Route::get('/doctors/register', [DoctorsController::class, 'createDoctor'])->name('doctors.register');
Route::post('/doctors/register', [DoctorsController::class, 'storeDoctor'])->name('doctors.store');

Route::get('/doctors/login', [DoctorsController::class, 'doctorLoginForm'])->name('doctors.login.form');
Route::post('/doctors/login', [DoctorsController::class, 'doctorLogin'])->name('doctors.login');

Route::middleware(['auth:doctors'])->group(function () {
    Route::get('/doctors/doctor-dashboard', [DoctorsController::class, 'doctorDashboard'])->name('doctors.doctor-dashboard');
    Route::get('/doctors/profile', [DoctorsController::class, 'doctorProfile'])->name('doctors.profile');
    Route::get('/doctors/patient-list', [DoctorsController::class, 'doctorPatientLists'])->name('doctors.patient-list');
    Route::post('/appointments/update-status', [DoctorsController::class, 'updateAppointmentStatus'])->name('appointments.updateStatus');

    Route::get('/doctors/edit-profile', [DoctorsController::class, 'editDoctorProfile'])->name('doctors.edit-profile');
    Route::put('/doctors/update-profile', [DoctorsController::class, 'updateDoctorProfile'])->name('doctors.update-profile');

    Route::get('/doctors/tech-support', [DoctorsController::class, 'techSupport'])->name('doctors.tech-support');
    Route::post('/doctors/submit-tech-support', [TechSupportController::class, 'submitTechSupport'])->name('doctors.submit-tech-support');
});

Route::post('/doctors/logout', [DoctorsController::class, 'doctorLogout'])->name('doctors.logout');


