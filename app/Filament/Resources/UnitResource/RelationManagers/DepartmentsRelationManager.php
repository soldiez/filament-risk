<?php

namespace App\Filament\Resources\UnitResource\RelationManagers;

use App\Models\Unit\Department;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class DepartmentsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'departments';

    protected static ?string $recordTitleAttribute = 'unit_id';

    protected static ?string $pluralLabel = 'Подразделения';

    protected static ?string $label = 'Подразделение';

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
                Tables\Columns\TextColumn::make('parent_id')->label(__('Родитель')),
                Tables\Columns\TextColumn::make('unit_id')->label(__('Предприятие'))->hidden(),
                Tables\Columns\TextColumn::make('name')->label(__('Имя')),
                Tables\Columns\TextColumn::make('manager_id')->label(__('Менеджер')),
                Tables\Columns\TextColumn::make('info')->label(__('Информация')),
                Tables\Columns\TextColumn::make('status')->label(__('Статус'))->hidden(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Создано')),
                Tables\Columns\TextColumn::make('updated_at')->label(__('Обновлено'))->hidden()
            ])
            ->filters([
                //
            ]);
    }
}
