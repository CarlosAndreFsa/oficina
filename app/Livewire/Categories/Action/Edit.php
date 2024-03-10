<?php

namespace App\Livewire\Categories\Action;

use App\Exceptions\AppException;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Modelable, Rule};
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    #[Modelable]
    public ?Category $category = null;

    public bool $show = false;

    #[Rule('required')]
    public string $name = '';

    public function render(): View
    {
        return view('livewire.categories.action.edit');
    }

    public function boot(): void
    {
        if (!$this->category) {
            $this->show = false;

            return;
        }

        $this->fill($this->category);
        $this->show = true;
    }

    /**
     * @throws AppException
     */
    public function save(): void
    {
        $data = $this->validate();

        if (!$this->category) {
            throw new AppException('Category not found.');
        }

        $this->category->update($data);

        $this->reset();
        $this->dispatch('category-saved');
        $this->success('Category updated.');
    }
}
