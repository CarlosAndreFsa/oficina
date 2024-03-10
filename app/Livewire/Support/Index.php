<?php

namespace App\Livewire\Support;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

class Index extends Component
{
    #[Layout('components.layouts.empty')]
    #[Title('Support us')]
    public function render(): View
    {
        return view('livewire.support.index');
    }
}
