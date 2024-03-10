<div>
    <x-header title="New Order" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Discard" link="/orders" icon="o-arrow-uturn-left" responsive />
        </x-slot:actions>
    </x-header>

    <div class="grid lg:grid-cols-2 gap-8">
        {{-- CUSTOMER --}}
        <div class="content-start">
            <x-card title="Customer" separator shadow>
                <x-slot:menu>
                    @if($user_id)
                        <x-button label="Confirm" wire:click="confirm" icon="o-check" class="btn-sm btn-primary" />
                    @endif
                </x-slot:menu>

                <x-choices
                    wire:model.live="user_id"
                    :options="$users"
                    option-sub-label="email"
                    hint="Search for customer name"
                    icon="o-magnifying-glass"
                    single
                    searchable />
            </x-card>
        </div>

        {{-- IMAGE --}}
        <div>
            <img src="/images/new-order.png" class="mx-auto" width="300px" />
        </div>
    </div>

</div>
