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
    ];

    protected const THERAPIST_REDIRECTS = [
        2 => 'therapists.occupationalTherapist',
        3 => 'therapists.speechTherapist',
        4 => 'therapists.physiotherapyTherapist',
        5 => 'therapists.nutritionist',
        9 => 'therapists.psychotherapyTherapist',
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

    protected function therapistRedirect($specialization_id)
    {
        $route = self::THERAPIST_REDIRECTS[$specialization_id] ?? null;

        return $route
            ? redirect()->route($route)
            : redirect(RouteServiceProvider::HOME);
    }
}
