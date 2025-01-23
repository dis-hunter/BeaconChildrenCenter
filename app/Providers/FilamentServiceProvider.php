<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::registerNavigationGroups([
            ['name'=>'Static Data', 'icon'=>'heroicon-o-circle-stack'],
        ]);
    }

    public function navigation() : array {
        return [
            NavigationGroup::make('Static Data')
                ->collapsed(),
        ];        
    }
}