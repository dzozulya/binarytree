<x-guest-layout>
    @if(!$exists)
    <h2>Tree autocreate</h2>
    <p>Please select maximun level</p>
    <form method="POST" action="{{ route('tree.generate') }}">
        @csrf

        <!-- Name -->

        <div>
            <x-input-label for="level" :value="__('Level')" />
            <x-text-input id="level" class="block " type="number" name="level" :value="old('level')" autofocus autocomplete="parent_id" />
            <x-input-error :messages="$errors->get('level')" class="mt-2" />
        </div>



            <x-primary-button >
                {{ __('Create Tree') }}
            </x-primary-button>
        </div>
    </form>
    @else
    <h3>Tree already builded</h3>
    @endif
</x-guest-layout>
