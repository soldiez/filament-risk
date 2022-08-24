<?php

namespace App\Filament\Pages;


use App\Models\Unit\Unit;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Tables\Columns\TextColumn;

use Filament\Forms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;


class UnitService extends Page
{
     use Forms\Concerns\InteractsWithForms;


    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.unit-service';

    protected static ?string $navigationGroup = 'Units';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Обслуживание';

    protected function getActions(): array
    {
        return [
            ButtonAction::make('settings')->action('openSettingsModal'),
        ];
    }

    public function openSettingsModal(): void
    {
        $this->dispatchBrowserEvent('open-settings-modal');
    }

    /**
     * @return string
     */

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Fieldset::make('asd')
            ->schema([
                TextInput::make('dsfsdf'),

            ]),


        ];
    }

    public function sendInfo(){
        $this->notify('success', __('Save'));
    }

//    protected function getFormSchema(): array
//    {
//        return [
//            Forms\Components\TextInput::make('title')->required(),
//            Forms\Components\MarkdownEditor::make('content'),
//            // ...
//        ];
//    }
//    public function mount(): void
//    {
//        $this->form->fill();
//    }
    public function submit(): void
    {
        // ...
    }




//    public static function form(Form $form): Form
//    {
//        return $form
//            ->schema([
//                //
//                Forms\Components\TextInput::make('short_name')->required()->label(__('Имя')),
//                Forms\Components\TextInput::make('long_name')->label(__('Полное имя')),
//                Forms\Components\TextInput::make('legal_address')->label(__('Юр.адрес')),
//                Forms\Components\TextInput::make('post_address')->label(__('Почт.адрес')),
//                Forms\Components\TextInput::make('status')->hidden()->default('active')->label(__('Статус')),
//            ]);
//    }
}
