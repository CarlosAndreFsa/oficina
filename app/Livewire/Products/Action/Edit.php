<?php

namespace App\Livewire\Products\Action;

use App\Actions\DeleteProductAction;
use App\Exceptions\AppException;
use App\Models\{Brand, Category, Product};
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Computed, On, Validate};
use Livewire\{Component, WithFileUploads};
use Mary\Traits\{Toast, WithMediaSync};

class Edit extends Component
{
    use Toast;
    use WithFileUploads;
    use WithMediaSync;

    public Product $product;

    public bool $editImages = false;

    #[Validate('required')]
    public int $brand_id;

    #[Validate('required')]
    public int $category_id;

    #[Validate('required')]
    public string $name;

    #[Validate('required|decimal:0,2|gt:0')]
    public string $price;

    #[Validate('required')]
    public string $description;

    #[Validate('required|integer')]
    public string $stock;

    #[Validate(['files.*' => 'image|max:1024'])]
    public array $files = [];

    #[Validate('nullable')]
    public ?Collection $library = null;

    #[Validate('nullable|image|max:1024')]
    public ?UploadedFile $cover_file = null;
    public function render(): View
    {
        return view('livewire.products.action.edit');
    }

    public function mount(): void
    {
        // We manually set library here
        $this->library = $this->product->library ?? new Collection();

        // Remove the library collection field, otherwise `fill()` will not work
        $this->product->setHidden(['library']);

        // Then the rest of attributes
        $this->fill($this->product);
    }

    #[On('brand-saved')]
    public function newBrand(int $id): void
    {
        $this->brand_id = $id;
    }

    #[On('category-saved')]
    public function newCategory(int $id): void
    {
        $this->category_id = $id;
    }

    #[Computed]
    public function brands(): Collection
    {
        return Brand::query()->orderBy('name')->get();
    }

    #[Computed]
    public function categories(): Collection
    {
        return Category::query()->orderBy('name')->get();
    }

    /**
     * @throws AppException
     */
    public function delete(): void
    {
        $delete = new DeleteProductAction($this->product);
        $delete->execute();

        $this->success('Product deleted.', redirectTo: route('products.index'));
    }

    public function save(): void
    {
        // Update product
        $this->product->update($this->validate());

        // Upload cover
        if ($this->cover_file) {
            $url = $this->cover_file->store('products', 'public');
            $this->product->update(['cover' => "/storage/$url"]);
        }

        // Upload library images
        $this->syncMedia($this->product, storage_subpath: 'products');

        $this->success('Product updated with success.', redirectTo: '/products');
    }
}
