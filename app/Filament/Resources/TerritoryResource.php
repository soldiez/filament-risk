<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TerritoryResource\Pages;
use App\Filament\Resources\TerritoryResource\RelationManagers;

use App\Models\Unit\Department;
use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TerritoryResource extends Resource
{
    protected static ?string $model = Territory::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Units';

    protected static ?string $navigationLabel = 'Территории';

    protected static ?string $pluralLabel = 'Территории';
    protected static ?string $label = 'Территория';

    protected static ?int $navigationSort = 2;




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('parent_id')->options(Territory::all()
                    ->pluck('name', 'id'))->searchable()->label(__('Родитель')),
                Forms\Components\Select::make('unit_id')->options(Unit::all()
                    ->pluck('short_name', 'id'))->searchable()->label(__('Предприятие')),


                Forms\Components\Fieldset::make('')
            ->schema([
                Forms\Components\TextInput::make('name')->label(__('Имя')),
                Forms\Components\Select::make('responsible_id')->label(__('Ответственное лицо'))
                    ->options(Worker::all()->pluck('last_name', 'id')),
            ]),

//                Forms\Components\Select::make('department_id')->label(__('Подразделение'))->options(Department::all()->pluck('name', 'id')),
//               Forms\Components\Fieldset::make(__('Контакты'))->schema([
//                   Forms\Components\TextInput::make('coordinate')->label(__('Координаты')),
//                   Forms\Components\TextInput::make('address')->label(__('Адрес')),
//                   Forms\Components\TextInput::make('info')->label(__('Информация')),
//               ])->columns(3),
                Forms\Components\Select::make('status')->default('active')->hidden()->label(__('Статус')),
            ]);
    }



    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('id')->label(__('Предприятие'))
                    ->formatStateUsing(function ($state){
                        $terr = Territory::find($state);
                        return Unit::find($terr->unit_id)?->short_name;
                      //  return Territory::with('unit')->get()?->unit->short_name;
                       // return $terr->name; //TODO unit name
                    })->sortable(),
                Tables\Columns\TextColumn::make('parent_id')->label(__('Родитель'))->sortable()->searchable()
                    ->formatStateUsing(function ($state){if(Territory::find($state) !== null){return Territory::find($state)->name;} return '-';})
                    ,


                Tables\Columns\TextColumn::make('name')->label(__('Имя'))->limit(15)->sortable()->searchable(),
//                Tables\Columns\TextColumn::make('responsible_id')->label(__('Отв.лицо'))->sortable()->searchable()
//                ->formatStateUsing(function ($state){if(Worker::find($state) !== null){return Worker::find($state)->last_name;} return '-';})
//                ,
//                Tables\Columns\TextColumn::make('coordinate')->label(__('Координаты'))->limit(10)->searchable()->hidden(),
//                Tables\Columns\TextColumn::make('address')->label(__('Адрес'))->limit(10)->searchable()->hidden(),
//                Tables\Columns\TextColumn::make('info')->label(__('Информация'))->limit(10)->searchable()->hidden(),
//                Tables\Columns\TextColumn::make('status')->label(__('Статус'))->hidden()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Создано'))->dateTime('d-m-Y')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label(__('Обновлено'))->dateTime('d-m-Y')->hidden()
            ])
            ->filters([
//                Tables\Filters\Filter::make('verified')
//                ->query(fn (Builder $query): Builder => $query->whereNotNull('territories.unit_id')),
                Tables\Filters\SelectFilter::make(__('Предприятие'))
                ->options(Unit::all()->pluck('short_name', 'id'))
                ->column('unit_id'),
                Tables\Filters\SelectFilter::make(__('Родитель'))
                ->options(

                    Territory::whereIn('id', Territory::get(['parent_id']))->get()->pluck('name', 'id'))//TODO for null
                ->column('parent_id', )

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\TerritoriesRelationManager::class,

        ];
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTerritories::route('/'),
            'create' => Pages\CreateTerritory::route('/create'),
            'edit' => Pages\EditTerritory::route('/{record}/edit'),
        ];
    }

}
