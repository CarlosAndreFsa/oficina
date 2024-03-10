<?php

namespace App\Livewire\Products\Action;

use App\Models\{Brand, Category, Product};
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Computed, On, Validate};
use Livewire\{Component, WithFileUploads};
use Mary\Traits\{Toast, WithMediaSync};

/**
 * @property-read Collection $brands
 * @property-read Collection $categories
 */
class Create extends Component
{
    use Toast;
    use WithFileUploads;
    use WithMediaSync;

    #[Validate('required')]
    public int $brand_id;

    #[Validate('required')]
    public int $category_id;

    #[Validate('required')]
    public string $name;

    #[Validate('required|decimal:0,2|gt:0')]
    public ?float $price;

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
        return view('livewire.products.action.create');
    }

    public function mount(): void
    {
        $this->library = new Collection();
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

    public function save(): void
    {
        // Validate
        $data = $this->validate();

        // Create
        $data['cover'] = '/images/empty-product.png';
        $product       = Product::query()->create($data);

        // Upload cover
        if ($this->cover_file) {
            $url = $this->cover_file->store('products', 'public');
            $product->update(['cover' => "/storage/$url"]);
        }

        // Upload library images
        $this->syncMedia($product);

        $this->success('Product created with success.', redirectTo: '/products');
    }
}
