<?php

namespace App\Filament\Resources\UnitResource\RelationManagers;

use App\Models\Unit\Territory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class TerritoriesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'territories';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Территория';

    protected static ?string $pluralLabel = 'Территории';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
              //  Forms\Components\TextInput::make('unitTerr'),
                Forms\Components\Select::make('parent_id')
                    ->options(Territory::all()->pluck('name', 'id'))->searchable()->label(__('Родитель')),
                Forms\Components\Fieldset::make('')
            ->schema([
                Forms\Components\TextInput::make('name')->label(__('Имя')),
                Forms\Components\Select::make('responsible_id')->label(__('Ответственное лицо')),
            ]),
            //    Forms\Components\Select::make('department_id')->label(__('Подразделение')),
//                Forms\Components\Fieldset::make('')
//            ->schema([
//                Forms\Components\TextInput::make('coordinate')->label(__('Координаты')),
//                Forms\Components\TextInput::make('address')->label(__('Адрес')),
//                Forms\Components\TextInput::make('info')->label(__('Информация')),
//            ])->columns(3),
//                Forms\Components\Select::make('status')->default('active')->hidden()->label(__('Статус')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
              //  Tables\Columns\TextColumn::make('unitTerr'),
                Tables\Columns\TextColumn::make('parent_id')->sortable()->label(__('Родитель'))
                    ->formatStateUsing(function ($state){if(Territory::find($state) !== null){return Territory::find($state)->name;} return $state;})
                ,
                Tables\Columns\TextColumn::make('name')->limit(15)->sortable()->label(__('Имя')),
                Tables\Columns\TextColumn::make('responsible_id')->sortable()->label(__('Отв.лицо'))->hidden(),
               // Tables\Columns\TextColumn::make('department_id')->sortable()->label(__('Подразделение')),
//                Tables\Columns\TextColumn::make('coordinate')->limit(10)->label(__('Координаты'))->hidden(),
//                Tables\Columns\TextColumn::make('address')->limit(10)->label(__('Адрес')),
//                Tables\Columns\TextColumn::make('info')->limit(10)->label(__('Информация'))->hidden(),
//                Tables\Columns\TextColumn::make('status')->hidden()->sortable()->label(__('Статус')),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d-m-Y')->sortable()->label(__('Создано')),
                Tables\Columns\TextColumn::make('updated_at')->hidden()->label(__('Обновлено'))
            ])
            ->filters([
                //
            ]);
    }
}
