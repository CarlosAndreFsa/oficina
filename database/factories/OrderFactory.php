<?php

namespace Database\Factories;

use App\Models\{Order, OrderStatus, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id'    => User::factory(),
            'status_id'  => OrderStatusFactory::new(),
            'total'      => $this->faker->randomFloat(2, 0, 999999.99),
            'created_at' => $this->faker->dateTimeBetween('-30 days'),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Order $order) {
            $order->update(['total' => $order->items()->sum('total')]);
        });
    }
}
