<?php

namespace App\Livewire\Users\Action;

use App\Models\{Country, User};
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\{Computed, Validate};
use Livewire\{Component, WithFileUploads};
use Mary\Traits\Toast;

/**
 * @property-read Collection $countries
 *
 */
class Create extends Component
{
    use Toast;
    use WithFileUploads;

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
        return view('livewire.users.action.create');
    }

    public function save(): void
    {
        // Validate
        $data = $this->validate();

        // Create
        $data['password'] = Hash::make('demo');
        $data['avatar']   = '/images/empty-user.jpg';
        $user             = User::query()->create($data);

        if ($this->avatar_file) {
            $url = $this->avatar_file->store('users', 'public');
            $user->update(['avatar' => "/storage/$url"]);
        }

        $this->success('Customer created with success.', redirectTo: '/users');
    }

    #[Computed]
    public function countries(): Collection
    {
        return Country::query()->orderBy('name')->get();
    }
}
