<?php

namespace App\Livewire\Products;

use App\Models\{Brand, Category, Product};
use App\Traits\{ClearsProperties, ResetsPaginationWhenPropsChanges};
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\{Computed, Url};
use Livewire\{Component, WithPagination};

/**
 * @property-read LengthAwarePaginator $products
 * @property-read Collection $categories
 * @property-read Collection $brands
 */
class Index extends Component
{
    use WithPagination;
    use ResetsPaginationWhenPropsChanges;
    use ClearsProperties;

    #[Url]
    public string $name = '';

    #[Url]
    public int $brand_id = 0;

    #[Url]
    public ?int $category_id = 0;

    #[Url]
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public bool $showFilters = false;
    public function render(): View
    {
        return view('livewire.products.index');
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'preview', 'label' => '', 'class' => 'w-14', 'sortable' => false],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'brand.name', 'label' => 'Brand', 'sortBy' => 'brand_name', 'class' => 'hidden lg:table-cell'],
            ['key' => 'category.name', 'label' => 'Category', 'sortBy' => 'category_name', 'class' => 'hidden lg:table-cell'],
            ['key' => 'price_human', 'label' => 'Price', 'sortBy' => 'price', 'class' => 'hidden lg:table-cell'],
            ['key' => 'stock', 'label' => 'Stock', 'class' => 'hidden lg:table-cell'],
        ];
    }

    #[Computed]
    public function products(): LengthAwarePaginator
    {
        return Product::query()
            ->with(['brand', 'category'])
            ->withAggregate('brand', 'name')
            ->withAggregate('category', 'name')
            ->when($this->name, fn (Builder $q) => $q->where('name', 'like', "%$this->name%"))
            ->when($this->brand_id, fn (Builder $q) => $q->where('brand_id', $this->brand_id))
            ->when($this->category_id, fn (Builder $q) => $q->where('category_id', $this->category_id))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(7);
    }

    #[Computed]
    public function brands(): Collection
    {
        return Brand::query()->get();
    }

    #[Computed]
    public function categories(): Collection
    {
        return Category::query()->get();
    }

    #[Computed]
    public function filterCount(): int
    {
        return ($this->category_id ? 1 : 0) + ($this->brand_id ? 1 : 0) + ($this->name !== '' ? 1 : 0);
    }
}
