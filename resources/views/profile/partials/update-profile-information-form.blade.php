<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Photo Upload -->
    <div class="mt-4">
        <x-input-label for="photo" :value="__('Profile Photo')" />
        @if ($user->photo)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo"
                    class="h-24 w-24 rounded-full object-cover">
            </div>
        @endif
        <x-text-input id="photo" class="block mt-1 w-full" type="file" name="photo" accept="image/*" />
        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
    </div>

    <!-- Submit Button -->
    <div class="flex items-center justify-end mt-6">
        <x-primary-button>
            {{ __('Update User') }}
        </x-primary-button>
    </div>
</form>
