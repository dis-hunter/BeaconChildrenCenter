<?php

namespace App\View\Components;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class DashboardLink extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $route = match(Auth::user()->role_id){
            1 => 'triage.dashboard',
            2 => 'doctor.dashboard',
            3 => 'reception.dashboard',
            default => RouteServiceProvider::HOME,
        };

        return view('components.dashboard-link', ['route' => $route]);
    }
}
