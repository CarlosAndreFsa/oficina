<?php

use App\Livewire\Users\Index;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Index::class)
        ->assertStatus(200);
});

it('should be able to check table', function () {
    Livewire::test(Index::class)
        ->assertSet(
            'headers',
            [
                ['key' => 'avatar', 'label' => '', 'class' => 'w-14', 'sortable' => false],
                ['key' => 'name', 'label' => 'Name'],
                ['key' => 'country.name', 'label' => 'Country', 'sortBy' => 'country_name', 'class' => 'hidden lg:table-cell'],
                ['key' => 'email', 'label' => 'E-mail', 'class' => 'hidden lg:table-cell'],
            ]
        );
});
