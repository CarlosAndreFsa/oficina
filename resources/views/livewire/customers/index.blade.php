
<div>
    {{--  HEADER  --}}
    <x-header title="Customers" separator progress-indicator>
        {{--  SEARCH --}}
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Name..." wire:model.live.debounce="search" icon="o-magnifying-glass" clearable />
        </x-slot:middle>

        {{-- ACTIONS  --}}
        <x-slot:actions>
            <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" clearable />
            <x-button label="Filters"
                      icon="o-funnel"
                      :badge="$this->filterCount"
                      badge-classes="font-mono"
                      {{-- @click="$wire.showFilters = true" --}}
                      class="bg-base-300"
                      responsive />

            <x-button label="Create" icon="o-plus" link="{{ route('customers.create') }}" class="btn-primary" responsive />
            {{-- <livewire:customers.action.create /> --}}
      
        </x-slot:actions>
    </x-header>
    {{--  TABLE --}}
    <x-card>
        <x-table :headers="$this->headers" :rows="$this->customers"  link="/customers/{id}/edit"  :sort-by="$sortBy" with-pagination>
            {{-- Avatar scope --}}
            {{-- @scope('cell_name', $customers)
            <x-avatar :image="$user->avatar" class="!w-10" />
            @endscope --}}
        </x-table>
    </x-card>

    {{-- FILTERS --}}
    <x-drawer wire:model="showFilters" title="Filters" class="lg:w-1/3" right separator with-close-button> --}}

        {{-- ACTIONS --}}
        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            {{-- <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.showFilters = false" /> --}}
        </x-slot:actions>
    </x-drawer>
</div>
