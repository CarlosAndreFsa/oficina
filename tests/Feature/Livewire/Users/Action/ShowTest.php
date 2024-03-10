<?php

use App\Livewire\Users\Action\Show;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();

    Livewire::test(Show::class, ['user' => $user])
        ->assertStatus(200);
});
