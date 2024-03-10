<?php

use App\Livewire\Orders\Action\Edit;
use App\Models\Order;
use Livewire\Livewire;

it('renders successfully', function () {
    $order = Order::factory()->create();

    Livewire::test(Edit::class, ['order' => $order])
        ->assertStatus(200);
});
