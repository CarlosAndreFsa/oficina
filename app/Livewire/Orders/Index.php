<?php

namespace App\Livewire\Orders;

use App\Models\{Country, Order, OrderStatus};
use App\Traits\{ClearsProperties, ResetsPaginationWhenPropsChanges};
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Computed, Url};
use Livewire\{Component, WithPagination};

/**
 * @property-read LengthAwarePaginator $orders
 * @property-read Collection $statuses
 * @property-read Collection $countries
 */
class Index extends Component
{
    use WithPagination;
    use ResetsPaginationWhenPropsChanges;
    use ClearsProperties;

    #[Url]
    public int $status_id = 0;

    #[Url]
    public ?int $country_id = 0;

    #[Url]
    public string $name = '';

    #[Url]
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public bool $showFilters = false;
    public function render(): View
    {
        return view('livewire.orders.index');
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'hidden lg:table-cell'],
            ['key' => 'date_human', 'label' => 'Date', 'sortBy' => 'created_at', 'class' => 'hidden lg:table-cell'],
            ['key' => 'user.name', 'label' => 'Customer', 'sortBy' => 'user_name'],
            ['key' => 'user.country.name', 'label' => 'Country', 'sortBy' => 'country_name', 'class' => 'hidden lg:table-cell'],
            ['key' => 'total_human', 'label' => 'Total', 'sortBy' => 'total'],
            ['key' => 'status', 'label' => 'Status', 'sortBy' => 'status_name', 'class' => 'hidden lg:table-cell'],
        ];
    }

    /**
     * Table query.
     *
     * These withAggregate() adds new columns on Collection making ease to sort it and is used by headers().
     *  Ex: `user_name`, `status_name`
     */
    #[Computed]
    public function orders(): LengthAwarePaginator
    {
        return Order::query()
            ->withAggregate('user', 'name')
            ->withAggregate('status', 'name')
            ->withAggregate('country as country_name', 'countries.name')
            ->when($this->status_id, fn (Builder $q) => $q->where('status_id', $this->status_id))
            ->when($this->country_id, fn (Builder $q) => $q->whereRelation('user', 'country_id', $this->country_id))
            ->when($this->name, fn (Builder $q) => $q->whereRelation('user', 'name', 'like', "%$this->name%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }

    // Count filter types
    #[Computed]
    public function filterCount(): int
    {
        return ($this->status_id ? 1 : 0) + ($this->country_id ? 1 : 0) + ($this->name !== '' ? 1 : 0);
    }

    // All status
    #[Computed]
    public function statuses(): Collection
    {
        return OrderStatus::query()->where('id', '<>', OrderStatus::DRAFT)->get();
    }

    // All countries
    #[Computed]
    public function countries(): Collection
    {
        return Country::query()->orderBy('name')->get();
    }
}
