<?php

use App\Livewire\Users\Action\Edit;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $users = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $users])
        ->assertStatus(200);
});
