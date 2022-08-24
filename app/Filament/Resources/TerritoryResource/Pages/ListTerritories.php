<?php

namespace App\Filament\Resources\TerritoryResource\Pages;

use App\Filament\Resources\TerritoryResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;

class ListTerritories extends ListRecords
{
    protected static string $resource = TerritoryResource::class;




    protected function getActions(): array
    {
        return [
            ButtonAction::make('create')->label(__('Создать территорию'))->url('/admin/territories/create')
        ];
    }

//    protected function getActions(): array
//    {
//        return [
//            ButtonAction::make('settings')->action('openSettingsModal')
//        ];
//    }
}
