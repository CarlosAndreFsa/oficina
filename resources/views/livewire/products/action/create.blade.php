<div>
    <x-header title="Create product" separator />

    <x-form wire:submit="save">
        <div class="grid lg:grid-cols-2 gap-8">
            {{-- DETAILS --}}
            <x-card title="Details" separator>
                <div class="grid gap-3 lg:px-3" wire:key="details">
                    <x-input label="Name" wire:model="name" />
                    <x-editor label="Description" wire:model="description" :config="['height' => 200]" />

                    {{-- BRANDS --}}
                    <x-choices-offline label="Brand" wire:model="brand_id" :options="$this->brands" single searchable>
                        <x-slot:append>
                            <livewire:brands.action.create label="" class="rounded-l-none" />
                        </x-slot:append>
                    </x-choices-offline>

                    {{-- CATEGORIES --}}
                    <x-choices-offline label="Categories" wire:model="category_id" :options="$this->categories" single searchable>
                        <x-slot:append>
                            <livewire:categories.action.create label="" class="rounded-l-none" />
                        </x-slot:append>
                    </x-choices-offline>

                    {{-- PRICE & STOCK --}}
                    <x-input label="Price" wire:model="price" prefix="USD" money />
                    <x-input label="Stock" wire:model="stock" placeholder="Units" x-mask="999" />

                </div>
            </x-card>
            {{-- IMAGES --}}
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
                    <x-image-library wire:model="files" wire:library="library" :preview="$library" hint="Max 1MB" />
                </x-card>
            </div>
        </div>

        <x-slot:actions>
            <x-button label="Cancel" link="/products" />
            <x-button label="Save" icon="o-paper-airplane" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
