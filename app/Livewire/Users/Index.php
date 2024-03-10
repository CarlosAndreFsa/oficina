<?php

namespace App\Livewire\Users;

use App\Models\{Country, User};
use App\Traits\{ClearsProperties, ResetsPaginationWhenPropsChanges};
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Computed, Url};
use Livewire\{Component, WithPagination};

/**
 * @property-read LengthAwarePaginator|User[] $users
 * @property-read Collection $countries
 * @property-read array $headers
 */
class Index extends Component
{
    use WithPagination;
    use ResetsPaginationWhenPropsChanges;
    use ClearsProperties;

    #[Url]
    public string $name = '';

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

    #[Computed]
    public function countries(): Collection
    {
        return Country::query()->orderBy('name')->get();
    }

    public function render(): View
    {
        return view('livewire.users.index');
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'avatar', 'label' => '', 'class' => 'w-14', 'sortable' => false],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'country.name', 'label' => 'Country', 'sortBy' => 'country_name', 'class' => 'hidden lg:table-cell'],
            ['key' => 'email', 'label' => 'E-mail', 'class' => 'hidden lg:table-cell'],
        ];
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::query()
            ->with(['country', 'orders.status'])
            ->withAggregate('country', 'name')
            ->when($this->name, fn (Builder $q) => $q->where('name', 'like', "%$this->name%"))
            ->when($this->country_id, fn (Builder $q) => $q->where('country_id', $this->country_id))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(7);
    }

}
