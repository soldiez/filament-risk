<?php

namespace App\Filament\Pages;

use App\Models\Unit\Department;
use App\Models\Unit\JobPosition;
use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Filament\Pages\Actions\ButtonAction;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.settings';

    protected function getActions(): array
    {
        return [
          ButtonAction::make('Clear base')->action('clearBase'),
            ButtonAction::make('Seed base')->action('seedBase')

        ];
    }

    public function clearBase (){
        Worker::truncate();
        JobPosition::truncate();
        Department::truncate();
        Territory::truncate();
        Unit::truncate();
       // \DB::table('territory_unit')->truncate();
    }
    public function seedBase(){
        \Artisan::call('db:seed');
    }
}
