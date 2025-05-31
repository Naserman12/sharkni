<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function mount(){
         $this->user     = Auth::user();     
        app()->setLocale($this->user->language); //تعين اللغة بناء على المستخدم
        session(['locale' => $this->user->language]); // تخزين اللغة في الجلسة
    }
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
           {{ app()->getLocale() == 'ha' ? 'Sabunta Kalamar sirri!' : 'Saved changed password!' }}  {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
           {{ app()->getLocale() == 'ha' ? ' Tabbatar cewa asusunku yana amfani da dogon, Kalamar Sirri bazuwar don zama amintacce' : 'Ensure your account is using a long, random password to stay secure.' }}
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-input-label for="update_password_current_password" />
            {{ app()->getLocale() == 'ha' ? 'Kalamar Sirri ta yanzu' : 'Current Password' }}
            <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password"  />
            {{ app()->getLocale() == 'ha' ? 'Sabuwar Kalamar Sirri' : 'New Password' }}
            <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        
        <div>
            <x-input-label for="update_password_password_confirmation"  />
            {{ app()->getLocale() == 'ha' ? 'Tabbatar da Kalamar Sirri' : 'Confirm Password' }}
            
            <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ app()->getLocale() == 'ha' ? 'Adana kalmar sirri' : 'Save' }}</x-primary-button>

            <x-action-message class="me-3 mt-2" on="password-updated">
                <x-primary-button>{{ app()->getLocale() == 'ha' ? 'An Tabbatar Da canza Kalamar Sirri!' : 'Saved changed password!' }}</x-primary-button>
            </x-action-message>
        </div>
    </form>
</section>
