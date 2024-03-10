<div>
    <x-header title="Order #{{ $order->id }}" separator>
        <x-slot:actions>
            <x-button label="Delete" icon="o-trash" wire:click="delete" class="btn-error" wire:confirm="Are you sure?" spinner responsive />
        </x-slot:actions>
    </x-header>

    <div class="grid lg:grid-cols-2 gap-8">
        {{-- CUSTOMER --}}
        <livewire:orders.customer :$order />

        {{-- SUMMARY --}}
        <x-card title="Summary" separator shadow>
            <x-slot:menu>
                <x-badge :value="$order->status->name" class="badge-sm {{ $order->status->color  }}" />
            </x-slot:menu>

            <div class="grid gap-2">
                <div class="flex gap-3 justify-between items-baseline px-10">
                    <div>Items</div>
                    <div class="border-b border-b-gray-400 border-dashed flex-1"></div>
                    <div class="font-black">({{ $order->items()->count() }})</div>
                </div>
                <div class="flex gap-3 justify-between items-baseline px-10">
                    <div>Total</div>
                    <div class="border-b border-b-gray-400 border-dashed flex-1"></div>
                    <div class="font-black">{{ $order->total_human }}</div>
                </div>
            </div>
        </x-card>
    </div>

    {{-- ITEMS --}}
    <x-card title="Items" separator progress-indicator="updateQuantity" shadow class="mt-8">
        <x-slot:menu>
            {{-- ADD ITEM --}}
            <livewire:orders.add-item :order="$order" />
        </x-slot:menu>

        <x-table :rows="$order->items" :headers="$this->headers">
            {{-- Cover image scope --}}
            @scope('cell_product.cover', $item)
            <x-avatar :image="$item->product->cover" class="!w-10 !rounded-lg" />
            @endscope

            {{-- Quantity scope --}}
            @scope('cell_quantity', $item, $quantities)
            <x-select wire:model.number="items.{{ $this->loop->index }}.quantity" :options="$quantities" wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                      class="select-sm !w-14" />
            @endscope

            {{-- Actions scope --}}
            @scope('actions', $item)
            <x-button icon="o-trash" wire:click="deleteItem({{ $item->id }})" spinner class="btn-ghost text-error btn-sm" />
            @endscope
        </x-table>

        @if(!$order->items->count())
            <x-icon name="o-list-bullet" label="Nothing here." class="text-gray-400 mt-5" />
        @endif
    </x-card>

    <div class="text-gray-400 text-xs mt-5">
        On this demo you are able to freely modify the order regardless its status.
        The orders goes to a random status after adding an item, just for better display on orders list.
        Of course, you should improve this business logic.
    </div>
</div>
