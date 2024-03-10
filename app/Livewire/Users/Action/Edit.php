<?php

namespace App\Livewire\Users\Action;

use App\Models\{Country, User};
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Computed, Validate};
use Livewire\{Component, WithFileUploads};
use Mary\Traits\Toast;

/**
 * @property User $user
 * @property-read Collection $countries
 */
class Edit extends Component
{
    use Toast;
    use WithFileUploads;

    public User $user;

    #[Validate('required')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public ?int $country_id = null;

    #[Validate('nullable|image|max:1024')]
    public ?UploadedFile $avatar_file = null;

    public function render(): View
    {
        return view('livewire.users.action.edit');
    }

    public function mount(): void
    {
        $this->fill($this->user);
    }
    public function save(): void
    {
        $data = $this->validate();

        $this->user->update($data);

        if ($this->avatar_file) {
            $url = $this->avatar_file->store('users', 'public');
            $this->user->update(['avatar' => "/storage/$url"]);
        }

        $this->success('Customer updated with success.', redirectTo: '/users');
    }

    #[Computed]
    public function countries(): Collection
    {
        return Country::query()->orderBy('name')->get();
    }

}
