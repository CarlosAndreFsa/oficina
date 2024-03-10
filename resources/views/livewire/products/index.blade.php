<div>
    {{--  HEADER  --}}
    <x-header title="Products" separator progress-indicator>
        {{--  SEARCH --}}
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Name..." wire:model.live.debounce="name" icon="o-magnifying-glass" clearable />
        </x-slot:middle>

        {{-- ACTIONS  --}}
        <x-slot:actions>
            <x-button
                label="Filters"
                icon="o-funnel"
                :badge="$this->filterCount"
                badge-classes="font-mono"
                @click="$wire.showFilters = true"
                class="bg-base-300"
                responsive />

            <x-button label="Create" icon="o-plus" link="{{ route('products.create') }}" class="btn-primary" responsive />
        </x-slot:actions>
    </x-header>

    {{--  TABLE --}}
    <x-card>
        <x-table :headers="$this->headers" :rows="$this->products" link="/products/{id}/edit" :sort-by="$sortBy" with-pagination>
            @scope('cell_preview', $product)
            <x-avatar :image="$product->cover" class="!w-10 !rounded-lg" />
            @endscope
        </x-table>
    </x-card>

    {{-- FILTERS --}}
    <x-drawer wire:model="showFilters" title="Filters" class="lg:w-1/3" right separator with-close-button>
        <div class="grid gap-5" @keydown.enter="$wire.showFilters = false">
            <x-input label="Name ..." wire:model.live.debounce="name" icon="o-user" inline />
            <x-select label="Brand" :options="$this->brands" wire:model.live="brand_id" icon="o-map-pin" placeholder="All" placeholder-value="0" inline />
            <x-select label="Category" :options="$this->categories" wire:model.live="category_id" icon="o-flag" placeholder="All" placeholder-value="0" inline />
        </div>

        {{-- ACTIONS --}}
        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.showFilters = false" />
        </x-slot:actions>
    </x-drawer>
</div>
