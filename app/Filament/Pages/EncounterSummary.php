<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use App\Models\Visits;

class EncounterSummary extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.encounter-summary';

    public $startDate;
    public $endDate;
    public $sortOrder = 'desc'; // Default: Show newest visits first
    public $visits = [];

    public function form(Form $form): Form
    {
        return $form->schema([
            DatePicker::make('startDate')->label('Start Date')->reactive()->afterStateUpdated(fn () => $this->fetchVisits()),
            DatePicker::make('endDate')->label('End Date')->reactive()->afterStateUpdated(fn () => $this->fetchVisits()),
        ]);
    }

    public function updatedSortOrder()
    {
        $this->fetchVisits(); // Automatically fetch data when sorting order changes
    }

    public function fetchVisits()
    {
        if ($this->startDate && $this->endDate) {
            $this->visits = Visits::select(['id', 'visit_date', 'child_id', 'doctor_id', 'visit_type'])
                ->whereBetween('visit_date', [$this->startDate, $this->endDate])
                ->with([
                    'child:id,fullname',
                    'doctor:id,fullname',
                    'visitType:id,visit_type'
                ])
                ->orderBy('visit_date', $this->sortOrder) // Apply sorting
                ->get();
        }
    }
}
