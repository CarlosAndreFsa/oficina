<?php

namespace App\Livewire\Brands\Action;

use App\Exceptions\AppException;
use App\Models\{Brand, Category};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Modelable, Rule};
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    #[Modelable]
    public ?Brand $brand = null;

    public bool $show = false;

    #[Rule('required')]
    public string $name = '';
    public function render(): View
    {
        return view('livewire.brands.action.edit');
    }

    public function boot(): void
    {
        if (!$this->brand) {
            $this->show = false;

            return;
        }

        $this->fill($this->brand);
        $this->show = true;
    }

    /**
     * @throws AppException
     */
    public function save(): void
    {
        $brand = $this->validate();

        if (!$this->brand) {
            throw new AppException('Brand not found.');
        }

        $this->brand->update($brand);

        $this->reset();
        $this->dispatch('brand-saved');
        $this->success('Brand updated.');
    }
}
