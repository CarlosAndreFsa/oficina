<?php

use App\Livewire\Products\Action\Edit;
use App\Models\Product;
use Livewire\Livewire;

it('renders successfully', function () {
    $products = Product::factory()->create();

    Livewire::test(Edit::class, ['product' => $products])
        ->assertStatus(200);
});
