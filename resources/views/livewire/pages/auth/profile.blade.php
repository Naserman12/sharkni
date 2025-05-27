<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class=" container mx-auto py-10">
        <div class=" bg-slate-500 rounded-lg p-6 max-w-2xl mx-auto">
            <h1 class=" text-3xl font-bold mb-6 flex items-center" >
                <span class="mr-2">@</span>
                {{ app()->getLocale() == 'ha' ? 'Bayanan Mutum: ' : 'Profile: '}} {{ $user->name }}
            </h1>

            <!-- Description -->
             <div class="space-y-4">
                <!-- profile picture -->
                 <div class="mb-6">
                    @if ($user->profile_picture)
                     <img src="{{ asset('storage' . $user->profile_picture) }}" alt="{{ $user->name }}" class=" w-32 h-32 rounded-full mx-auto object-cover">
                        
                    @else
                        <div class=" w-32 h-32 bg-gray-200 rounded-full mx-auto flex items-center justify-center">
                            <span class=" text-gray-800">{{  app()->getLocale() == 'ha' ? 'Babu Horo' : 'NO image '}}</span>
                        </div>
                    @endif
                 </div>
                 <!-- Email -->
                 <div class=" text-gray-800">
                    <span class=" font-semibold">@</span>
                    {{ $user->email }}
                 </div>
                 <!-- Phone number -->
                 <div class=" text-gray-800">
                    <span class=" font-semibold">@</span>
                    {{ $user->phone ?? (app()->getLocale() == 'ha' ? 'Babu lambar waya' : 'No phone number ') }}
                 </div>
                 
                 <!-- Verification -->
                  <div class=" text-gray-800">
                    <span class=" font-semibold"> {{ app()->getLocale() == 'ha' ? 'Tabbatarwa' : 'Verification '}} </span>
                    @if ($user->email_verified_at)
                        {{ app()->getLocale() == 'ha' ? 'An tabbatar da imel' : 'Verified via email' }}
                    @else
                        {{ app()->getLocale() == 'ha' ? 'Ba a tabbatar ba ' : 'Not verified' }}
                    @endif
                  </div>
                  <!-- السمعة  -->
                   <div class=" text-gray-800">
                     <span class=" font-semibold"> {{ app()->getLocale() == 'ha' ? 'Daraja' : 'Reputation' }}</span>
                     ***** (12 {{ app()->getLocale() == 'ha' ? 'Kima ' : 'reviews' }})
                   </div>
             </div>
             <!-- الأدوات المدرجة -->
              <div class="mt-6">
                <h2 class=" text-xl font-semibold mb-4">
                    {{ app()->getLocale() == 'ha' ? 'Kayan Aiki Na ' : 'My Listed Tools ' }}
                </h2>
                @forelse ($tools as $tool )
                    <p class=" text-gray-800">
                        - {{ $tool->name }}
                        @if ($tool->is_free)
                            [{{ app()->getLocale() == 'ha' ? 'Kyauta ' : 'Free' }}]
                        @else
                            [{{ app()->getLocale() == 'ha' ? 'Biya ' : 'Paid ' }}]
                        @endif
                    </p>
                @empty
                 <p class=" text-gray-600">
                    {{ app()->getLocale() == 'ha' ? 'Baba kayan aiki da ka jera.' : 'No tools listed' }}
                 </p>
                @endforelse
              </div>
              <!-- Buttons -->
               <div class=" mt-6 flex space-x-4">
                <a href="{{ route('tools.add') }}" class=" bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600">
                    {{ app()->getLocale() == 'ha' ? 'Qara kayan akik ' : 'Add Tool' }}
                </a>||
                <a href="{{ route('profile') }}" class=" bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-700">
                    {{ app()->getLocale() == 'ha' ? 'Gyara Bayanan Ka' : 'Edit Profile' }}
                </a>||
                <a href="{{ route('logout') }}" class=" bg-red-500 text-white p-3 rounded-lg hover:bg-red-600">
                    {{ app()->getLocale() == 'ha' ? 'Qara kayan akik ' : 'Add Tool' }}
                </a>
               </div>
        </div>
    </div>
</div>
