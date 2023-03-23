<x-guest-layout>
    <form method="POST" action="{{ route('tree.store') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="parent_id" :value="__('Parent_id')" />
            <x-text-input id="parent_id" class="block mt-1 w-full" type="text" name="parent_id" :value="old('parent_id')" autofocus autocomplete="parent_id" />
            <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="position" :value="__('Position')" />
            <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')"  autocomplete="position" />
            <x-input-error :messages="$errors->get('position')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" autocomplete="title" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <!-- Confirm Password -->

        <div class="flex items-center justify-end mt-4">


            <x-primary-button >
                {{ __('Create Tree Element') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
