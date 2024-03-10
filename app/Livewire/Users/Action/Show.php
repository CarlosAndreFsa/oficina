<?php

namespace App\Livewire\Users\Action;

use App\Models\{Order, OrderItem, User};
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property User $user
 * @property-read Collection $favorites
 * @property-read Collection $orders
 * @property-read array $headers
 */
class Show extends Component
{
    public User $user;
    public function render(): View
    {
        return view('livewire.users.action.show');
    }

    public function mount(): void
    {
        $this->user->load(['country']);
    }

    #[Computed]
    public function favorites(): Collection
    {
        return OrderItem::query()
            ->with('product.category')
            ->selectRaw('count(1) as amount, product_id')
            ->whereRelation('order', 'user_id', $this->user->id)
            ->groupBy('product_id')
            ->orderByDesc('amount')
            ->take(2)
            ->get()
            ->transform(function (OrderItem $item) {
                $product         = $item->product;
                $product->amount = $item->amount;

                return $product;
            });
    }

    #[Computed]
    public function orders(): Collection
    {
        return Order::with(['user', 'status'])
            ->where('user_id', $this->user->id)
            ->latest('id')
            ->take(5)
            ->get();
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'date_human', 'label' => 'Date'],
            ['key' => 'total_human', 'label' => 'Total'],
            ['key' => 'status', 'label' => 'Status', 'class' => 'hidden lg:table-cell'],
        ];
    }
}
