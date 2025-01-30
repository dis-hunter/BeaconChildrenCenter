<?php

namespace App\Http\Responses;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    protected const ROLE_REDIRECTS = [
        1 => 'triage.dashboard',    // Nurse
        2 => 'doctor.dashboard',    // Doctor
        3 => 'reception.dashboard', // Reception
        4 => null,                  // RemoveAdmin
        5 => null,                  // Therapist - handled separately
    ];

    protected const THERAPIST_REDIRECTS = [
        2 => 'occupational_therapist',
        // 3 => 'other_route',
        // Add other specialization routes as needed
    ];

    public function toResponse($request)
    {
        if (!Auth::check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        $user = Auth::user();

        if ($user->role_id === 5) {
            return $this->therapistRedirect($user->specialization_id);
        }

        return redirect()->route(
            self::ROLE_REDIRECTS[$user->role_id] ?? RouteServiceProvider::HOME
        );
    }

    protected function therapistRedirect($specializationId)
    {
        $route = self::THERAPIST_REDIRECTS[$specializationId] ?? null;

        return $route
            ? redirect()->route($route)
            : redirect(RouteServiceProvider::HOME);
    }
}
