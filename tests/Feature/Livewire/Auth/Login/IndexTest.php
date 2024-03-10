<?php

use App\Livewire\Auth\Login\Index;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Index::class)
        ->assertStatus(200);
});

it('should be able to login', function () {
    $user = User::factory()->create([
        'email'    => 'joe@gmail.com',
        'password' => 'password',
    ]);
    Livewire::test(Index::class)
        ->set('email', 'joe@gmail.com')
        ->set('password', 'password')
        ->call('tryToLogin')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard.index'));

    expect(auth()->check())
        ->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);
});

it('should make sure to inform the user if the credentials are invalid', function () {
    Livewire::test(Index::class)
        ->set('email', 'joe@gmail.com')
        ->set('password', 'password')
        ->call('tryToLogin')
        ->assertHasErrors(['invalidCredentials'])
        ->assertSee(trans('auth.failed'));

});

it('should make sure that rate limiting is blocking after 5 attempts', function () {

    User::factory()->create([
        'email'    => 'joe@gmail.com',
        'password' => 'password',
    ]);

    for ($i = 0; $i < 5; $i++) {
        Livewire::test(Index::class)
            ->set('email', 'joe@gmail.com')
            ->set('password', 'wrong-password')
            ->call('tryToLogin')
            ->assertHasErrors(['invalidCredentials']);
    }

    Livewire::test(Index::class)
        ->set('email', 'joe@gmail.com')
        ->set('password', 'wrong-password')
        ->call('tryToLogin')
        ->assertHasErrors(['rateLimitExceeded']);
});
