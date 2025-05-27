<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h1>
    </x-slot>

    <div class=" container mx-auto py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
            <div class="p-4 sm:p-8 bg-stone-700 rounded-lg shadow-lg  sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8  bg-stone-700  rounded-lg shadow-lg sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8  bg-stone-700 rounded-lg shadow-lg sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
