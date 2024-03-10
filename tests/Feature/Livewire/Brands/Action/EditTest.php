<?php

use App\Livewire\Brands\Action\Edit;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Edit::class)
        ->assertStatus(200);
});
