<?php

namespace App\Livewire\Categories;

use App\Actions\DeleteCategoryAction;
use App\Exceptions\AppException;
use App\Models\Category;
use App\Traits\ResetsPaginationWhenPropsChanges;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\{Computed, On, Url};
use Livewire\{Component, WithPagination};
use Mary\Traits\Toast;

/**
 * @property-read LengthAwarePaginator $categories
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

    // Selected Category to edit on modal
    public ?Category $category = null;
    public function render(): View
    {
        return view('livewire.categories.index');
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

    #[Computed]
    public function categories(): LengthAwarePaginator
    {
        return Category::query()
            ->withCount('products')
            ->when($this->search, fn (Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(9);
    }
    #[On('category-saved')]
    #[On('category-cancel')]
    public function clear(): void
    {
        $this->reset();
    }

    public function edit(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @throws AppException
     */
    public function delete(Category $category): void
    {
        $delete = new DeleteCategoryAction($category);
        $delete->execute();

        $this->success('Category deleted.');
    }
}
