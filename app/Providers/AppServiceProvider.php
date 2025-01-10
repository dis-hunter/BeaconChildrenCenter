<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\View;
use App\Models\DoctorSpecialization;

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
        Password::default(function(){
            return env('APP_ENV')=='local' ?
                Password::min(6) :
                Password::min(6)
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised();
        });

        View::share('doctorSpecializations', DoctorSpecialization::all());

    }
}
