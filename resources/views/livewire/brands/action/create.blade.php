<div>
    <x-button :label="$label" @click="$wire.show = true" icon="o-plus" class="btn-primary {{ $class }}" responsive />

    {{-- This component can be used inside another forms. So we teleport it to body to avoid nested form submission conflict --}}
    <template x-teleport="body">
        <x-modal wire:model="show" title="Create Brand">
            <hr class="mb-5" />
            <x-form wire:submit="save">
                <x-input label="Name" wire:model="name" />

                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.show = false" />
                    <x-button label="Save" icon="o-paper-airplane" class="btn-primary" type="submit" />
                </x-slot:actions>
            </x-form>
        </x-modal>
    </template>
</div>
