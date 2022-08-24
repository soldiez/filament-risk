<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use App\Models\Unit\Department;
use App\Models\Unit\JobPosition;
use App\Models\Unit\Unit;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class JobPositionsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'jobPositions';

    protected static ?string $recordTitleAttribute = 'department_id';

    protected static ?string $label = 'Должность';

    protected static ?string $pluralLabel = 'Должности';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('parent_id')->label(__('Родитель'))->options(JobPosition::all()->pluck('name', 'id')),
                Forms\Components\TextInput::make('name')->label(__('Имя')),
                Forms\Components\Select::make('unit_id')->label(__('Предприятие'))->options(Unit::all()->pluck('short_name', 'id')),
                Forms\Components\Select::make('department_id')->label(__('Подразделение'))->options(Department::all()->pluck('name', 'id')),
                Forms\Components\TextInput::make('grade')->label(__('Грейд')),
                Forms\Components\TextInput::make('info')->label(__('Информация')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('parent_id')->label(__('Родитель')),
              //  Tables\Columns\TextColumn::make('department_id')->label(__('Подразделение')),
                Tables\Columns\TextColumn::make('unit_id')->label(__('Предприятие')),
                Tables\Columns\TextColumn::make('name')->label(__('Имя')),
                Tables\Columns\TextColumn::make('grade')->label(__('Грейд'))->hidden(),
                Tables\Columns\TextColumn::make('info')->label(__('Информация'))->hidden(),
                Tables\Columns\TextColumn::make('status')->label(__('Статус'))->hidden(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Создано')),
                Tables\Columns\TextColumn::make('updated_at')->label(__('Обновлено'))->hidden()
            ])
            ->filters([
                //
            ]);
    }
}
