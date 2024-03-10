<?php

namespace App\Livewire\Orders\Action;

use App\Actions\Order\{DeleteOrderAction, DeleteOrderItemAction, UpdateOrderItemQuantityAction};
use App\Models\{Order, OrderItem, OrderStatus, User};
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Computed, Validate};
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public ?int $user_id = null;

    public Collection $users;
    public function render(): View
    {
        return view('livewire.orders.action.create');
    }

    public function mount(): void
    {
        $this->search();
    }

    public function search(string $value = ''): void
    {
        $selectedOption = User::query()->where('id', $this->user_id)->get();

        $this->users = User::query()
            ->where('name', 'like', "%$value%")
            ->take(5)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);
    }

    public function confirm(): void
    {
        $order = Order::query()->create([
            'user_id'   => $this->user_id,
            'status_id' => OrderStatus::DRAFT,
        ]);

        $this->success('Order created', redirectTo: "/orders/{$order->id}/edit");
    }

}
