<div>
    <x-header :title="$user->name" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Delete" icon="o-trash" wire:click="delete" class="btn-error" wire:confirm="Are you sure?" spinner responsive />
        </x-slot:actions>
    </x-header>

    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <x-form wire:submit="save">
                <x-file label="Avatar" wire:model="avatar_file" accept="image/png, image/jpeg" hint="Click to change | Max 1MB" crop-after-change>
                    <img src="{{ $user->avatar ?? '/images/empty-user.jpg' }}" class="h-40 rounded-lg mb-3" />
                </x-file>
                <x-input label="Name" wire:model="name" />
                <x-input label="Email" wire:model="email" />
                <x-select label="Country" wire:model="country_id" :options="$this->countries" placeholder="---" />

                <x-slot:actions>
                    <x-button label="Cancel" link="/users" />
                    <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
                </x-slot:actions>
            </x-form>
        </div>
        <div>
            <img src="/images/edit-form.png" width="300" class="mx-auto" />
        </div>
    </div>
</div>
