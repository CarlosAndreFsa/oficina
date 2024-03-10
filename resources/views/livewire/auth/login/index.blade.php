<div class="mt-20 md:w-96 mx-auto">
    <x-flow-brand class="mb-8"/>
    <div class="max-w-sm mx-auto">
        @if(session('status'))
            <x-alert icon="o-exclamation-triangle" class="alert-warning">
                {{ session('status') }}
            </x-alert>
        @endif

        @if($errors->hasAny('invalidCredentials', 'rateLimitExceeded'))
            <x-alert icon="o-exclamation-triangle" class="alert-warning">
                @error('invalidCredentials')
                {{ $errors->first('invalidCredentials') }}
                @enderror
                @error('rateLimitExceeded')
                {{ $errors->first('rateLimitExceeded') }}
                @enderror
            </x-alert>
        @endif
    </div>
    <x-form wire:submit="tryToLogin"  class="mt-4">
        <x-input label="E-mail" value="random@random.com" icon="o-envelope" wire:model="email" inline/>
        <x-input label="Password" value="random" type="password" icon="o-key" wire:model="password" inline/>

        <x-slot:actions>
            <x-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="tryToLogin"/>
        </x-slot:actions>
    </x-form>
</div>
