<?php

namespace App\Filament\Resources\TerritoryResource\RelationManagers;

use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class TerritoriesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'territories';

    protected static ?string $recordTitleAttribute = 'parent_id';

    protected static ?string $pluralLabel = 'Территории';

//    protected function getFormModel(): Model|string|null
//    {
//        $unit_id = $this->ownerRecord->unit_id;
//    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['unit_id'] = $this->ownerRecord->unit_id;
        return $data;
    }

    public static function form(Form $form): Form
    {


        return
            $form
            ->schema([
//                Forms\Components\TextInput::make('name')->label(__('Имя')),
//                Forms\Components\Select::make('responsible_id')->label(__('Ответственное лицо')),
                    Forms\Components\TextInput::make('name')->label(__('Имя')),
                    Forms\Components\Select::make('responsible_id')->label(__('Ответственное лицо')),
                Forms\Components\Select::make('unit_id')->label(__('Предприятие'))
                ->options(Unit::all()->pluck('short_name', 'id')),

//   Forms\Components\Select::make('parent_id')->options(Territory::all()->pluck('name', 'id'))->label(__('Родитель')),
//                Forms\Components\Select::make('parent_id')->options(Territory::all()->pluck('name', 'id'))->searchable(),
//                Forms\Components\Select::make('department_id')->label(__('Подразделение')),

//                Forms\Components\Fieldset::make(__('Контакты'))
//                ->schema([
//                    Forms\Components\TextInput::make('coordinate')->label(__('Координаты')),
//                    Forms\Components\TextInput::make('address')->label(__('Адрес')),
//                    Forms\Components\TextInput::make('info')->label(__('Информация')),
//                ])->columns(3),
//                Forms\Components\Select::make('status')->default('active')->hidden()->label(__('Статус')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
              //  Tables\Columns\TextColumn::make('parent_id')->sortable(),
                Tables\Columns\TextColumn::make('name')->limit(15)->sortable()->label(__('Имя')),
                Tables\Columns\TextColumn::make('responsible_id')->sortable()->label(__('Отв.лицо')),
                Tables\Columns\TextColumn::make('unit_id')->sortable()->label(__('Предприятие')),
//                Tables\Columns\TextColumn::make('coordinate')->limit(10)->label(__('Координаты')),
//                Tables\Columns\TextColumn::make('address')->limit(10)->label(__('Адрес')),
//                Tables\Columns\TextColumn::make('info')->limit(10)->label(__('Информация')),
//                Tables\Columns\TextColumn::make('status')->hidden()->sortable()->label(__('Статус')),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d-m-Y H:i')->sortable()->label(__('Создано')),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('d-m-Y H:i')->hidden()->label(__('Обновлено'))
            ])
            ->filters([
                //
            ]);
    }
}
