<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Visits;

class EncounterSummary extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.encounter-summary';

    public $startDate;
    public $endDate;
    public $visits = [];

    public function form(Form $form): Form
    {
        return $form->schema([
            DatePicker::make('startDate')
                ->label('Start Date')
                ->reactive()
                ->afterStateUpdated(fn () => $this->fetchVisits()),

            DatePicker::make('endDate')
                ->label('End Date')
                ->reactive()
                ->afterStateUpdated(fn () => $this->fetchVisits()),
        ]);
    }

    public function fetchVisits()
    {
        if ($this->startDate && $this->endDate) {
            $this->visits = Visits::whereBetween('visit_date', [$this->startDate, $this->endDate])
                ->with(['child', 'doctor', 'visitType'])
                ->get();
        }
    }
}
