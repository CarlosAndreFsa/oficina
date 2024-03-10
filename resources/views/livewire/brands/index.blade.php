<div>
    {{--  HEADER  --}}
    <x-header title="Brands" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" clearable />
        </x-slot:middle>
        <x-slot:actions>
            <livewire:brands.action.create />
        </x-slot:actions>
    </x-header>

    {{--  TABLE --}}
    <x-card>
        <x-table :headers="$this->headers" :rows="$this->brands" @row-click="$wire.edit($event.detail.id)" :sort-by="$sortBy" with-pagination>
            @scope('actions', $brand)
            <x-button wire:click="delete({{ $brand->id }})" icon="o-trash" class="btn-sm btn-ghost text-error" wire:confirm="Are you sure?" spinner />
            @endscope
        </x-table>
    </x-card>

    {{--   EIDT MODAL --}}
    <livewire:brands.action.edit wire:model="brand" />
</div>
