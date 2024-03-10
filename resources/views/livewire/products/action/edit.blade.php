<div>
    <x-header :title="$product->name" separator>
        <x-slot:actions>
            <x-button label="Delete" icon="o-trash" wire:click="delete" class="btn-error" wire:confirm="Are you sure?" spinner responsive />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="save">
        <div class="grid lg:grid-cols-2 gap-8">
            {{-- DETAILS --}}
            <x-card title="Details" separator>
                <div class="grid gap-5 lg:px-3" wire:key="details">
                    <x-input label="Name" wire:model="name" />

                    <x-choices-offline label="Brand" wire:model="brand_id" :options="$this->brands" single searchable>
                        <x-slot:append>
                            <livewire:brands.action.create label="" class="rounded-l-none" />
                        </x-slot:append>
                    </x-choices-offline>

                    <x-choices-offline label="Categories" wire:model="category_id" :options="$this->categories" single searchable>
                        <x-slot:append>
                            <livewire:categories.action.create label="" class="rounded-l-none" />
                        </x-slot:append>
                    </x-choices-offline>

                    <x-input label="Price" wire:model="price" prefix="USD" money />
                    <x-input label="Stock" wire:model="stock" placeholder="Units" x-mask="999" />
                    <x-editor label="Description" wire:model="description" :config="['height' => 200]" />
                </div>
            </x-card>

            <div class="grid content-start gap-8">
                {{-- COVER IMAGE --}}
                <x-card title="Cover" separator>
                    <div class="flex">
                        <x-file wire:model="cover_file" accept="image/png, image/jpeg" hint="Click to change | Max 1MB" class="mx-auto">
                            <img src="{{  $product->cover ?? '/images/empty-product.png' }}" class="h-48 !rounded-lg my-3" />
                        </x-file>
                    </div>
                </x-card>

                {{-- MORE IMAGES --}}
                <x-card title="More images" separator>
                    <x-slot:menu>
                        @if($product->library?->count())
                            <x-button label="{{ $editImages ? 'Close' : 'Edit' }}" class="btn-ghost btn-sm" wire:click="$toggle('editImages')" />
                        @endif
                    </x-slot:menu>

                    @if(!$editImages && $product->library?->count())
                        <x-image-gallery :images="$product->library->pluck('url')->toArray()" class="h-60 rounded-box my-3" />
                    @endif

                    @if($editImages || $product->library?->count() === 0)
                        <x-image-library wire:model="files" wire:library="library" :preview="$library" hint="Max 1MB" />
                    @endif
                </x-card>
            </div>
        </div>

        <x-slot:actions>
            <x-button label="Cancel" link="/products" />
            <x-button label="Save" icon="o-paper-airplane" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
