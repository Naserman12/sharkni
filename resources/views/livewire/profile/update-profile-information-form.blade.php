<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\Volt\Component;


new class extends Component
{
    use WithFileUploads;
    public $user , $phone, $language, $profile_picture , $Orprofile_picture;
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {   
        $this->user     = Auth::user();     
        app()->setLocale($this->user->language); //تعين اللغة بناء على المستخدم
        session(['locale' => $this->user->language]); // تخزين اللغة في الجلسة
        $this->name                 = $this->user->name;
        $this->email                = $this->user->email;
        $this->phone                = $this->user->phone;
        $this->language             = $this->user->language;
        $this->profile_picture      = $this->user->profile_picture;
        $this->Orprofile_picture    = $this->user->profile_picture;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation()
    {
        $user = Auth::user();
        if ($user->email) {
            $user->email_verified_at = null;
            $user->save();
        }
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'language' => ['required', 'in:en,ha'],
            'profile_picture' => ['nullable', 'image', 'max:1024'],

        ]);

        if ($user->profile_picture = $this->profile_picture) {
            if (File::exists('Storage/'.$user->profile_picture)) {
               Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $this->profile_picture->store('profile_picture', 'public');
            $validated['profile_picture'] = $path;
        }
        $user->update($validated);
        if ($this->email !== $user->email) {
            $user->sendEmailVerificationNotification();
            session()->flash('message', app()->getLocale() == 'ha' ? 'An Sake aiko da imel na tabbatarwa saboda an canza imel qin ka.' : 'A new verfication email has been sent due to email change');
        }else{
            session()->flash('message', app()->getLocale() == 'ha' ? 'An sabunta bayanan mutum cikin nasara! ' : 'Profile udate successfully!');
        }

        // $user->fill($validated);

        // if ($user->isDirty('email')) {
        //     $user->email_verified_at = null;
        // }

       return redirect()->route('profile');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-3xl font-bold flex items-center ">
            {{ app()->getLocale() == 'ha' ? 'Gyara bayanan mutum' : 'Edit profile '}}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Messages -->
      @if (session('message'))
  <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
    {{ $message }}
  </div>   
  @endif
  @error('form')
  <div class="mb-4 p-2 bg-red-100 text-red-700 rounded">
    {{ $message }}
  </div>   
  @enderror
    <form wire:submit.prevent="updateProfileInformation" class="mt-6 space-y-6">
        <!-- name -->
        <div>
            <x-input-label for="name" />
            <i class="fas fa-user mr-2"></i>{{ app()->getLocale() == 'ha' ? 'Suna' : 'Name' }}
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full"  autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        
        <!-- email -->
        <div>
            <x-input-label for="email"/>
            <i class="fas fa-envelope mr-2"></i>{{ app()->getLocale() == 'ha' ? 'Imel' : 'Email' }}
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full"  autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />     
            </div>
            
            <!-- Phone -->
            <div>
                <x-input-label for="phone"  />
                <i class="fas fa-phone mr-2"></i>{{ app()->getLocale() == 'ha' ? 'Lambat waya' : 'Phone number' }}
                <x-text-input wire:model="phone" id="phone" name="phone" type="text" class="mt-1 block w-full" autofocus autocomplete="phone" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            <!-- Language -->
            <div>
                <x-input-label for="language" />
                <i class="fas fa-language mr-2"></i>{{ app()->getLocale() == 'ha' ? 'Harshe' : 'Language' }}
                <select name="language" wire:model="language" class=" w-full p-2 border rounded" id="language">
                    <option value="en">{{ app()->getLocale() == 'ha' ? 'Turanci' : 'English' }}</option>
                    <option value="ha">{{ app()->getLocale() == 'ha' ? 'Hausa' : 'Hausa' }}</option>
                 </select>
                <x-input-error class="mt-2" :messages="$errors->get('language')" />
            </div>
            <!-- Image -->
            @if ($user->profile_picture)
                <div class=" mt-2">
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class=" w-32 h-32 rounded-full">
                </div>
            @endif
           
                <x-input-label for="profile_picture" />
                <i class="fas fa-image mr-2"></i>{{ app()->getLocale() == 'ha' ? 'Hoton' : 'profile picture' }}
                <x-text-input wire:model="profile_picture" id="profile_picture" name="profile_picture" type="file" class="block w-full p-2 border rounded" autofocus autocomplete="profile_picture" />
                <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
            </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
