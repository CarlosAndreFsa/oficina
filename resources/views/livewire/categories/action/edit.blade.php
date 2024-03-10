<div>
    <x-modal wire:model="show" title="Update Category" persistent>
        <x-hr class="mb-5" />
        <x-form wire:submit="save">
            <x-input label="Name" wire:model="name" />

            <x-slot:actions>
                <x-button label="Cancel" @click="$dispatch('category-cancel')" />
                <x-button label="Update" icon="o-paper-airplane" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>
</div>
