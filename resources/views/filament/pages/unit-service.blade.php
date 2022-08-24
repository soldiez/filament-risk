<x-filament::page>

    <div class="flex flex-rows flex-wrap">
        <div class="basis-3/4">
            {{$this->form}}
        </div class=basis-1/4>
        <x-filament::button wire:click="sendInfo">
            Send Info
        </x-filament::button>
    </div>


</x-filament::page>







