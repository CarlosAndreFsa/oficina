<?php

namespace App\Livewire\Brands\Action;

use App\Models\Brand;
use App\Traits\HasCssClassAttribute;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;
    use HasCssClassAttribute;

    #[Rule('required')]
    public ?string $name = '';

    public bool $show = false;

    public string $label = 'Create';
    public function render(): View
    {
        return view('livewire.brands.action.create');
    }

    public function save(): void
    {
        /** @var Brand $brand */
        $brand = Brand::query()->create($this->validate());

        $this->show = false;
        $this->resetExcept('label', 'class');
        $this->dispatch('brand-saved', id: $brand->id);
        $this->success('Brand created.');
    }
}
