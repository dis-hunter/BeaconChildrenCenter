<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ChildAppointmentSearchBar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ChildAppointmentSearchBarTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(ChildAppointmentSearchBar::class);

        $component->assertStatus(200);
    }
}
