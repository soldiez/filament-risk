<?php

namespace App\Filament\Resources\JobPositionResource\Pages;

use App\Filament\Resources\JobPositionResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;

class ListJobPositions extends ListRecords
{
    protected static string $resource = JobPositionResource::class;

    protected function getActions(): array
    {
        return [
            ButtonAction::make('create')->label(__('Создать должность'))->url('/admin/job-positions/create')
        ];
    }
}
