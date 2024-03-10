<?php

use App\Livewire\Categories\Action\Create;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});
