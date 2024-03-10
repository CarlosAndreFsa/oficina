<?php

use App\Livewire\Orders\Action\Create;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});
