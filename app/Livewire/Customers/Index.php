<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Traits\{ClearsProperties, ResetsPaginationWhenPropsChanges};
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\{Computed, Url};
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;
    use ResetsPaginationWhenPropsChanges;
    use ClearsProperties;

    #[Url]
    public string $name = '';

    #[Url]
    public string $search = '';

    #[Url]
    public ?int $country_id = 0;

    #[Url]
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public bool $showFilters = false;

    #[Computed]
    public function filterCount(): int
    {
        return ($this->country_id ? 1 : 0) + ($this->name !== '' ? 1 : 0);
    }

    public function render(): View
    {

        return view('livewire.customers.index');
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'name', 'label' => 'Name', 'sortBy' => 'Name'],
            ['key' => 'socialReason', 'label' => 'Razao Social', 'class' => 'hidden lg:table-cell'],
            ['key' => 'cnpj', 'label' => 'CNPJ', 'class' => 'hidden lg:table-cell'],
            ['key' => 'created_at', 'label' => 'created_at', 'class' => 'hidden lg:table-cell'],
        ];
    }
    #[Computed]
    public function customers(): LengthAwarePaginator
    {

        return Customer::query()
        ->when($this->search, fn (Builder $q) => $q->where('name', 'like', "%$this->search%"))
        ->orderBy(...array_values($this->sortBy))
        ->paginate(10);

    }
}
