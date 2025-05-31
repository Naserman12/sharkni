<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ app()->getLocale() == 'ha' ? 'Shate Account' : 'Delete Account' }} 
        </h2>
        
        <p class="mt-1 text-sm text-gray-600">
            {{ app()->getLocale() == 'ha' ? 'Da zara an share asusun ku, duk albarkatunsa 
                                            za a goge su har abada.
                                            Kafin share asusun ku, da faten za a zazzage kowane
                                            bayanai ko bayaninnda kuki son riqwa.' 
                                            : 'Once your account is deleted, all of its resources and data will be
                                            permanently deleted. Before deleting your account, please download 
                                            any data or information that you wish to retain.' }}
          
        </p>
    </header>
    
    <x-danger-button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ app()->getLocale() == 'ha' ? 'Shate Account' : 'Delete Account' }} </x-danger-button>
    
    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">
            
            <h2 class="text-lg font-medium text-gray-900">
                {{ app()->getLocale() == 'ha' ? 'Shin kun tabbatar kuna son share asusun ku?' : 'Are you sure you want to delete your account?' }} 
            </h2>     
            <p class="mt-1 text-sm text-gray-600">
                {{ app()->getLocale() == 'ha' ? 'Da faten za a sgigar da kalmar 
                                                 sirri don tabbatar da wewa kuna son share asusunku.'
                                                        : 'Once your account is deleted, all of its
                                                        resources and data will be permanently deleted.
                                                        Please enter your password to confirm you would
                                                        like to permanently delete your account.' }} 
            </p>
            <div class="mt-6">
                <x-input-label for="password" class="sr-only" />
                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ app()->getLocale() == 'ha' ? 'Kalamar Sirri' : ' Password' }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ app()->getLocale() == 'ha' ? 'Nafasa' : 'Cancel' }}
                </x-secondary-button>
                <x-danger-button class="ms-3 mt-2">
                   {{ app()->getLocale() == 'ha' ? 'Goge asusu gaba daya' : 'Delete account' }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
