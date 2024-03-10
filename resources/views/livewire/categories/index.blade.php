<div>
    {{--  HEADER  --}}
    <x-header title="Categories" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" clearable />
        </x-slot:middle>
        <x-slot:actions>
            <livewire:categories.action.create />
        </x-slot:actions>
    </x-header>

    {{-- TABLE --}}
    <x-card>
        <x-table :headers="$this->headers" :rows="$this->categories" @row-click="$wire.edit($event.detail.id)" :sort-by="$sortBy" with-pagination>
            @scope('actions', $category)
            <x-button wire:click="delete({{ $category->id }})" icon="o-trash" class="btn-sm btn-ghost text-error" wire:confirm="Are you sure?" spinner />
            @endscope
        </x-table>
    </x-card>

    {{-- EDIT MODAL --}}
    <livewire:categories.action.edit wire:model="category" />
</div>
