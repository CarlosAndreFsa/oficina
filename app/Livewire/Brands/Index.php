<?php

namespace App\Livewire\Brands;

use App\Actions\DeleteBrandAction;
use App\Exceptions\AppException;
use App\Models\Brand;
use App\Traits\ResetsPaginationWhenPropsChanges;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\{Computed, On, Url};
use Livewire\{Component, WithPagination};
use Mary\Traits\Toast;

/**
 * @property-read LengthAwarePaginator $brands
 * @property-read array $headers
 */
class Index extends Component
{
    use Toast;
    use WithPagination;
    use ResetsPaginationWhenPropsChanges;

    #[Url]
    public string $search = '';

    #[Url]
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    // Selected Brand to edit on modal
    public ?Brand $brand;
    public function render(): View
    {
        return view('livewire.brands.index');
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-20'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'products_count', 'label' => 'Products', 'class' => 'w-32', 'sortBy' => 'products_count'],
            ['key' => 'date_human', 'label' => 'Created at', 'class' => 'hidden lg:table-cell'],
        ];
    }

    public function edit(Brand $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @throws AppException
     */
    public function delete(Brand $brand): void
    {
        $delete = new DeleteBrandAction($brand);
        $delete->execute();

        $this->success('Brand deleted.');
    }

    #[Computed]
    public function brands(): LengthAwarePaginator
    {
        return Brand::query()
            ->withCount('products')
            ->when($this->search, fn (Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(9);
    }

    #[On('brand-saved')]
    #[On('brand-cancel')]
    public function clear(): void
    {
        $this->reset();
    }
}
