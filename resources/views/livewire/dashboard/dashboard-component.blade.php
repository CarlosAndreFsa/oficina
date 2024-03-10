<div>
    <x-header title="Dashboard" separator progress-indicator>
        <x-slot:actions>
            <x-select :options="$this->periods" wire:model.live="period" icon="o-calendar" />
        </x-slot:actions>
    </x-header>
    {{--  STATISTICS   --}}
    <livewire:dashboard.stats :$period />

    <div class="grid lg:grid-cols-6 gap-8 mt-8">
        {{-- GROSS --}}
        <div class="col-span-6 lg:col-span-4">
            <livewire:dashboard.chart-gross :$period />
        </div>

        {{-- PER CATEGORY --}}
        <div class="col-span-6 lg:col-span-2">
            <livewire:dashboard.chart-category :$period />
        </div>
    </div>

    <div class="grid lg:grid-cols-4 gap-8 mt-8">
        {{-- TOP CUSTOMERS --}}
        <div class="col-span-2">
            <livewire:dashboard.top-customers :$period />
        </div>

        {{-- BEST SELLERS --}}
        <div class="col-span-2">
            <livewire:dashboard.best-sellers :$period />
        </div>

    </div>

    {{-- LATEST ORDERS --}}
    <livewire:dashboard.oldest-orders :$period />
</div>
