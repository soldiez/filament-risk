<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Filament\Resources\DepartmentResource\RelationManagers;
use App\Models\Unit\Department;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-grid';

    protected static ?string $navigationGroup = 'Units';

    protected static ?string $label = 'Подразделение';

    protected static ?string $pluralLabel = 'Подразделения';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('parent_id')->label(__('Родитель'))->options(Department::all()->pluck('name', 'id')),
                Forms\Components\TextInput::make('name')->label(__('Имя')),
                Forms\Components\Select::make('unit_id')->label(__('Предприятие'))->options(Unit::all()->pluck('short_name', 'id')),
                Forms\Components\Select::make('manager_id')->label(__('Менеджер'))->options(Worker::all()->pluck('last_name', 'id')),
                Forms\Components\TextInput::make('info')->label(__('Информация')),
                Forms\Components\TextInput::make('status')->label(__('Статус'))->hidden()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('parent_id')->label(__('Родитель'))
                    ->formatStateUsing(function ($state){if(Department::find($state) !== null){return Department::find($state)->name;} return '-';})
                ,
                Tables\Columns\TextColumn::make('unit_id')->label(__('Предприятие'))
                    ->formatStateUsing(function ($state){if(Unit::find($state) !== null){return Unit::find($state)->short_name;} return '-';})
                ,
                Tables\Columns\TextColumn::make('name')->label(__('Имя')),
                Tables\Columns\TextColumn::make('manager_id')->label(__('Менеджер'))
                    ->formatStateUsing(function ($state){if(Worker::find($state) !== null){return Worker::find($state)->last_name;} return '-';})
                ,
                Tables\Columns\TextColumn::make('info')->label(__('Информация'))->limit(20),
                Tables\Columns\TextColumn::make('status')->label(__('Статус'))->hidden(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Создано'))->dateTime('d-m-Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')->label(__('Обновлено'))->dateTime('d-m-Y H:i')->hidden()
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\JobPositionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
