<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TerritoryResource\RelationManagers\UnitsRelationManager;
use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\RelationManagers;

use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-office-building';

    protected static ?string $navigationGroup = 'Units';

    protected static ?string $navigationLabel = 'Предприятия';

    protected static ?string $pluralLabel = 'Предприятия';

    protected static ?string $label = 'Предприятие';

    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                    Forms\Components\TextInput::make('short_name')->required()->label(__('Имя')),
                    Forms\Components\TextInput::make('long_name')->label(__('Полное имя')),
                Forms\Components\FileUpload::make('logo_unit')->label(__('Логотип'))->image()
                    ->imagePreviewHeight('100')->maxSize(2048),
                Forms\Components\Select::make('parent_id')
                    ->options(Unit::all()->pluck('short_name', 'id'))->searchable()->label(__('Головная компания')),


                    Forms\Components\TextArea::make('legal_address')->label(__('Юридический адрес')),
                    Forms\Components\TextArea::make('post_address')->label(__('Почтовый адрес')),
                    Forms\Components\TextInput::make('phone_main')->label(__('Телефон'))->tel()
                        ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('+3{8}(000)000-00-00')),
                    Forms\Components\TextInput::make('phone_reserve')->label(__('Резервный телефон'))->tel()
                        ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('+3{8}(000)000-00-00')),
                    Forms\Components\TextInput::make('email')->label(__('Почта'))->email(),
Forms\Components\Fieldset::make('')
            ->schema([
                Forms\Components\Select::make('manager_id')->label(__('Менеджер'))
                    ->options(Worker::all()->pluck('last_name', 'id')),
                Forms\Components\Select::make('safety_manager_id')->label(__('Охрана труда'))
                    ->options(Worker::all()->pluck('last_name', 'id')),
            ]),



                Forms\Components\TextInput::make('status')->hidden()->default('active')->label(__('Статус')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\ImageColumn::make('logo_unit')->label(__('Логотип')),
              //  Tables\Columns\TextColumn::make('id')->label(__('id')),
                Tables\Columns\TextColumn::make('short_name')->label(__('Имя'))->sortable()->searchable()->limit(15),
                Tables\Columns\TextColumn::make('long_name')->label(__('Полное имя'))->searchable()->hidden(),
                Tables\Columns\TextColumn::make('phone_main')->label(__('Телефон'))->searchable()->hidden(),
                Tables\Columns\TextColumn::make('phone_reserve')->label(__('Рез.тел.'))->searchable()->hidden(),
                Tables\Columns\TextColumn::make('email')->label(__('Почта'))->sortable()->searchable()->limit(15)->hidden(),
                Tables\Columns\TextColumn::make('legal_address')->label(__('Юр.адрес'))->searchable()->limit(20),
                Tables\Columns\TextColumn::make('post_address')->label(__('Почт.адрес'))->searchable()->limit(20)->hidden(),
                Tables\Columns\TextColumn::make('manager_id')->label(__('Менеджер'))->sortable()
                    ->formatStateUsing(function ($state){if(Worker::find($state) !== null){return Worker::find($state)->fullName();} return '-';})
                ,
                Tables\Columns\TextColumn::make('safety_manager_id')->label(__('Охрана труда'))->sortable()->hidden(),
                Tables\Columns\TextColumn::make('parent_id')->label(__('Родит.'))->sortable()->hidden(),
                Tables\Columns\TextColumn::make('status')->label(__('Статус'))->sortable()->hidden(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Создано'))->sortable()->dateTime('d-m-Y'),
                Tables\Columns\TextColumn::make('updated_at')->label(__('Обновлено'))->sortable()->hidden(),
            ])
            ->filters([
                //
//
//                Tables\Filters\SelectFilter::make('Name')->label(__('Родитель'))
//            ->query(fn (Builder $query): Builder => $query->whereIn('id', Unit::whereNotNull('parent_id')->get('parent_id')))->options()
//                ,

//                Tables\Filters\Filter::make('active')
//                ->query(fn (Builder $query): Builder => $query->whereNotNull('status'))
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\TerritoriesRelationManager::class,
            RelationManagers\DepartmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }
}
