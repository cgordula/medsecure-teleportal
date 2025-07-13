<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $doctorAppointmentCounts = Appointment::select('doctor_id', DB::raw('COUNT(*) as count'))
            ->groupBy('doctor_id')
            ->with('doctor')
            ->orderByDesc('count')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->doctor->first_name . ' ' . $item->doctor->last_name,
                    'count' => $item->count
                ];
            });

        $appointmentsBySpecialization = Appointment::join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
        ->select('doctors.specialization', DB::raw('count(*) as total'))
        ->groupBy('doctors.specialization')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

        $appointmentStatusBreakdown = Appointment::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();
    
        View::share('doctorAppointmentCounts', $doctorAppointmentCounts);
        View::share('appointmentsBySpecialization', $appointmentsBySpecialization);
        View::share('appointmentStatusBreakdown', $appointmentStatusBreakdown);

    }
}
