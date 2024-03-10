<?php

namespace App\Traits\Livewire;

use App\Support\Table\Header;
use Livewire\Attributes\Computed;

trait HasTable
{
    public ?string $search = null;

    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

    /**@return Header[] */
    abstract public function tableHeaders(): array;

    #[Computed]
    public function headers(): array
    {
        return collect($this->tableHeaders())
            ->map(fn (Header $header) => [
                'key'   => $header->key,
                'label' => $header->label,
                'class' => $header->class ?? '',
            ])
            ->toArray();
    }

}
