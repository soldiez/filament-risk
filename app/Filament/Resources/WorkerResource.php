<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkerResource\Pages;
use App\Filament\Resources\WorkerResource\RelationManagers;
use App\Models\Unit\Department;
use App\Models\Unit\JobPosition;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class WorkerResource extends Resource
{
    protected static ?string $model = Worker::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Units';

    protected static ?string $label = 'Сотрудник';

    protected static ?string $pluralLabel = 'Сотрудники';

    protected static ?int $navigationSort = 5;

    //for translate
    protected static function getNavigationGroup(): ?string
    {
        return __('Units');
    }


    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                //
                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\TextInput::make('last_name')->label(__('Фамилия'))->required(),
                        Forms\Components\TextInput::make('first_name')->label(__('Имя'))->required(),
                        Forms\Components\TextInput::make('middle_name')->label(__('Отчество')),
                    ])->columns(3),
                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\Select::make('unit_id')->label(__('Предприятие'))->options(Unit::all()->pluck('short_name', 'id')),
                        Forms\Components\Select::make('department_id')->label(__('Подразделение'))->options(Department::all()->pluck('name', 'id')),
                        Forms\Components\Select::make('job_position_id')->label(__('Должность'))->options(JobPosition::all()->pluck('name', 'id')),
                        ])->columns(3),
                Forms\Components\Fieldset::make('')
            ->schema([
                Forms\Components\TextInput::make('personnel_number')->label(__('Таб.номер')),
                Forms\Components\TextInput::make('phone')->label(__('Телефон')),
                Forms\Components\TextInput::make('email')->label(__('Почта')),
            ])->columns(3),

                Forms\Components\DatePicker::make('birthday')->label(__('Дата рождения')),
                Forms\Components\TextInput::make('status')->label(__('Статус'))->hidden(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('last_name')->label(__('Фамилия')),
                Tables\Columns\TextColumn::make('first_name')->label(__('Имя')),
                Tables\Columns\TextColumn::make('middle_name')->label(__('Отчество')),
                Tables\Columns\TextColumn::make('phone')->label(__('Телефон'))->hidden(),
                Tables\Columns\TextColumn::make('email')->label(__('Почта'))->hidden(),
                Tables\Columns\TextColumn::make('personnel_number')->label(__('Таб.номер'))->hidden(),
                Tables\Columns\TextColumn::make('job_position_id')->label(__('Должность'))
                    ->formatStateUsing(function ($state){if(JobPosition::find($state) !== null){return JobPosition::find($state)->name;} return '-';})
                ,
                Tables\Columns\TextColumn::make('department_id')->label(__('Подразделение'))
                    ->formatStateUsing(function ($state){if(Department::find($state) !== null){return Department::find($state)->name;} return '-';})
                ,
                Tables\Columns\TextColumn::make('unit_id')->label(__('Предприятие'))
                    ->formatStateUsing(function ($state){if(Unit::find($state) !== null){return Unit::find($state)->short_name;} return '-';})
                ,
                Tables\Columns\TextColumn::make('birthday')->label(__('Дата рождения'))->dateTime('d-m-Y')->hidden(),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkers::route('/'),
            'create' => Pages\CreateWorker::route('/create'),
            'edit' => Pages\EditWorker::route('/{record}/edit'),
        ];
    }

}
