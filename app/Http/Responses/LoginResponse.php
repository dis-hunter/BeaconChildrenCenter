<?php
namespace App\Http\Responses;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract{
    public function toResponse($request)
    {
        if(Auth::check()){
            switch (Auth::user()->role_id) {
                case 1: //Nurse
                    return redirect()->route('triage.dashboard');
                case 2: //Doctor
                    return redirect()->route('doctor.dashboard');
                case 3: //Reception
                    return redirect()->route('reception.dashboard');
                case 4: //RemoveAdmin
                    // return redirect()->route('user.dashboard');
                case 5: //Therapist
                    return $this->therapist_redirect();
                default:
                    return redirect(RouteServiceProvider::HOME);
            }
        }else{
            return redirect(RouteServiceProvider::HOME);
        }
    }

    protected function therapist_redirect(){
        switch (Auth::user()->specialization_id) {
            case 2:
                return redirect()->route('occupational_therapist');
                break;

            case 3:
                // return redirect()->route('reception.dashboard');
                // break;

            case 4:
                // return redirect()->route('user.dashboard');
                // break;

            case 5:
                //return redirect()->route('occupational_therapist');
                // break;
            case 6:
                // return redirect()->route('therapist.dashboard');
                // break;
            case 8:
                // return redirect()->route('therapist.dashboard');
                // break;
            case 9:
                // return redirect()->route('therapist.dashboard');
                // break;
            case 10:
                // return redirect()->route('therapist.dashboard');
                // break;
            default:
                // return redirect()->route('home');
                // break;
        }
    }
}
