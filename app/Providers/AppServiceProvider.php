<?php

namespace App\Providers;

use App\Auth\CachedEloquentUserProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\View;
use App\Models\DoctorSpecialization;
use App\Models\LeaveType;

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

        auth()->provider('cachedEloquent', function (Application $application, array $config){
            return new CachedEloquentUserProvider($application['hash'], $config['model']);
        });



//        DB::listen(function ($query){
//            Log::info($query->sql);
//        });
//        View::share('doctorSpecializations', DoctorSpecialization::all());
//
//
//        // Share leave types with all views
//        $leaveTypes = LeaveType::all(); // Retrieve all leave types
//
//        // Share the leaveTypes variable globally
//        View::share('leaveTypes', $leaveTypes);

    }
}
