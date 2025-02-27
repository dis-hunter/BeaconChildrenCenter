<?php

namespace App\Http\Responses;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    protected const ROLE_REDIRECTS = [
        1 => 'triage.dashboard',    // Nurse
        2 => 'doctor.dashboard',    // Doctor
        3 => 'reception.dashboard', // Reception
        4 => 'filament.admin.pages.dashboard', //Admin
    ];

    public function toResponse($request)
    {
        if (!Auth::check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        $user = Auth::user();

        if ($user->role_id === 5) {
            return redirect()->route(
                'therapistsDashboard' ?? RouteServiceProvider::HOME
            );
        }

        return redirect()->route(
            self::ROLE_REDIRECTS[$user->role_id] ?? RouteServiceProvider::HOME
        );
    }
}
