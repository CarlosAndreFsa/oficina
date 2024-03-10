<?php

namespace App\Livewire\Auth\Login;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\{Auth, RateLimiter, Redirect, Request};
use Illuminate\Support\Str;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

class Index extends Component
{
    public ?string $email = null;

    public ?string $password = null;
    #[Layout('components.layouts.empty')]
    #[Title('Login')]
    public function render(): View
    {
        return view('livewire.auth.login.index');
    }

    public function tryToLogin(): void
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            $this->addError('rateLimitExceeded', trans('auth.throttle', [
                'seconds' => RateLimiter::availableIn($this->throttleKey()),
            ]));

            return;
        }

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {

            RateLimiter::hit($this->throttleKey());

            $this->addError('invalidCredentials', trans('auth.failed'));

            return;
        }
        $this->redirect(route('dashboard.index'));
    }

    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower((string) $this->email) . '|' . Request::ip());
    }
}
