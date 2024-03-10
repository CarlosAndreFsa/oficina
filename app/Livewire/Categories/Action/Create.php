<?php

namespace App\Livewire\Categories\Action;

use App\Models\Category;
use App\Traits\HasCssClassAttribute;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Modelable, Rule};
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;
    use HasCssClassAttribute;

    #[Rule('required')]
    public string $name = '';

    public bool $show = false;

    public string $label = 'Create';

    public function render(): View
    {
        return view('livewire.categories.action.create');
    }

    public function save(): void
    {
        /** @var Category $category */
        $category = Category::query()->create($this->validate());

        $this->show = false;
        $this->resetExcept('label', 'class');
        $this->dispatch('category-saved', id: $category->id);
        $this->success('Category created.');
    }

}
