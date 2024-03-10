<?php

namespace App\Livewire\Orders\Action;

use App\Actions\Order\{DeleteOrderAction, DeleteOrderItemAction, UpdateOrderItemQuantityAction};
use App\Exceptions\AppException;
use App\Models\{Order, OrderItem};
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Computed, On, Validate};
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public Order $order;

    #[Validate(['items.*.quantity' => 'required|integer'])]
    public array $items = [];

    public function render(): View
    {
        return view('livewire.orders.action.edit', ['quantities' => $this->quantities()]);
    }

    public function mount(): void
    {
        $this->order->load(['status', 'items.product.brand', 'items.product.category']);
        $this->items = $this->order->items->toArray();
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'product.cover', 'label' => '', 'sortable' => false, 'class' => 'w-14 px-1 lg:px-3'],
            ['key' => 'product.name', 'label' => 'Product', 'class' => 'hidden lg:table-cell'],
            ['key' => 'product.brand.name', 'label' => 'Brand', 'class' => 'hidden lg:table-cell'],
            ['key' => 'product.category.name', 'label' => 'Category', 'class' => 'hidden lg:table-cell'],
            ['key' => 'quantity', 'label' => 'Qty'],
            ['key' => 'price_human', 'label' => 'Price', 'class' => 'hidden lg:table-cell'],
            ['key' => 'total_human', 'label' => 'Total'],
        ];
    }

    #[On('item-added')]
    public function refreshItems(): void
    {
        $this->items = $this->order->items->toArray();
    }

    public function updateQuantity(OrderItem $item, int $quantity): void
    {
        $update = new UpdateOrderItemQuantityAction($item, $quantity);
        $update->execute();

        $this->order->refresh();
    }

    // Delete the order

    /**
     * @throws AppException
     */
    public function delete(): void
    {
        $delete = new DeleteOrderAction($this->order);
        $delete->execute();

        $this->success('Order deleted with success.', redirectTo: '/orders');
    }

    // Remove an item for order

    /**
     * @throws AppException
     */
    public function deleteItem(OrderItem $item): void
    {
        $remove = new DeleteOrderItemAction($item);
        $remove->execute();
        $this->success('Item removed.');

        $this->order->refresh();
    }

    // Quantities to display on x-select
    public function quantities(): Collection
    {
        $items = collect();

        collect(range(1, 9))->each(fn ($item) => $items->add(['id' => $item, 'name' => $item]));

        return $items;
    }
}
