<?php

namespace App\Actions\Order;

use App\Exceptions\AppException;
use App\Models\{Order, OrderItem, OrderStatus, Product};
use Illuminate\Support\Facades\DB;
use Throwable;

class AddItemToOrderAction
{
    public function __construct(
        private readonly Order $order,
        private array          $item
    ) {
    }

    /**
     * @throws AppException
     */
    public function execute(): void
    {
        try {
            DB::beginTransaction();

            $alreadyOnOrder = $this->order
                ->items()
                ->where('product_id', $this->item['product_id'])
                ->count();

            if ($alreadyOnOrder) {
                throw new AppException('This item already exists. Or another person just added this same item. Refresh the page.');
            }

            /** @var Product $product */
            $product = Product::query()->find($this->item['product_id']);

            if (!$product) {
                throw new AppException('Product not found.');
            }

            OrderItem::query()->create([
                'order_id'   => $this->order->id,
                'product_id' => $this->item['product_id'],
                'quantity'   => $this->item['quantity'],
                'price'      => $product->price,
                'total'      => $product->price * $this->item['quantity'],
            ]);

            $recalculate = new RecalculateOrderTotalAction($this->order);
            $recalculate->execute();

            // Change to a random status (for demo purpose) if still DRAFT
            if ($this->order->status_id === OrderStatus::DRAFT) {

                /** @var OrderStatus $status */
                $status = OrderStatus::query()->where('id', '<>', OrderStatus::DRAFT)->inRandomOrder()->first();

                if (!$status) {
                    throw new AppException('Order status not found.');
                }

                $this->order->update([
                    'status_id' => $status->id,
                ]);
            }

            DB::commit();
        } catch (AppException $e) {
            throw $e;
        } catch (Throwable $e) {
            DB::rollBack();

            throw new AppException('Whoops!');
        }
    }
}
