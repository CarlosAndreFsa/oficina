<?php

namespace App\Livewire\Dashboard;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, Url};
use Livewire\Component;

/**
 * @property-read array $periods
 */
class DashboardComponent extends Component
{
    #[Url]
    public string $period = '-30 days';

    public function render(): View
    {
        return view('livewire.dashboard.dashboard-component');
    }

    #[Computed]
    public function periods(): array
    {
        return [
            [
                'id'   => '-7 days',
                'name' => 'Last 7 days',
            ],
            [
                'id'   => '-15 days',
                'name' => 'Last 15 days',
            ],
            [
                'id'   => '-30 days',
                'name' => 'Last 30 days',
            ],
        ];
    }
}
