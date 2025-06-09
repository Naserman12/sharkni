<div>
    {{-- The best athlete wants his opponent at his best. --}}
    @php
     $user = Auth()->user();
     app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
     session(['locale' => $user->language]); // تخزين اللغة في الجلسة
    @endphp
    <div class=" container mx-auto py-10">
        <div class=" bg-gradient-to-r from-orange-200 to-yellow-100 rounded-lg p-6 max-w-2xl mx-auto">
            <h1 class=" text-3xl font-bold mb-6 flex items-center" >
                <span class="mr-2"><i class="fas fa-user"></i></span>
                {{ app()->getLocale() == 'ha' ? 'Bayanan Mutum: ' : 'Profile: '}} {{ $user->name }}
            </h1>
            <!-- messages -->
             @if (session('message'))
             <div class=" mb-4 p-2 bg-green-200 text-green-700">
             {{ session('message') }} 
             </div>
             @endif
             @if (session('success'))
             <div class=" mb-4 p-2 bg-green-200 text-green-700">
             {{ session('success') }} 
             </div>
             @endif
            
            <!-- Description -->
             <div class="space-y-4">
                <!-- profile picture -->
                 <div class="mb-6">
                    @if ($user->profile_picture)
                     <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class=" w-32 h-32 bg-gray-200 rounded-full mx-auto flex items-center justify-center">
                    @else
                        <div class=" w-32 h-32 bg-gray-200 rounded-full mx-auto flex items-center justify-center">
                            <i class="fas fa-user text-gray-800 text-2xl"></i>
                        </div>
                    @endif
                 </div>
                 <!-- Email -->
                 <div class=" text-gray-800">
                    <span class=" font-semibold"><i class="fas fa-envelope"></i></span>
                    {{ $user->email }}
                 </div>
                 <!-- Phone number -->
                 <div class=" text-gray-800">
                    <span class=" font-semibold"><i class="fas fa-phone"></i></span>
                    {{ $user->phone ?? (app()->getLocale() == 'ha' ? 'Babu lambar waya' : 'No phone number ') }}
                 </div>
                 
                 <!-- Verification -->
                  <div class=" text-gray-800">
                    <span class=" font-semibold"><i class="fas fa-check-circle"></i> {{ app()->getLocale() == 'ha' ? 'Tabbatarwa' : 'Verification '}} </span>
                    @if ($user->email_verified_at)
                        {{ app()->getLocale() == 'ha' ? 'An tabbatar da imel' : 'Verified via email' }}
                    @else
                        {{ app()->getLocale() == 'ha' ? 'Ba a tabbatar ba ' : 'Not verified' }}
                    @endif
                  </div>
                  <!-- السمعة  -->
                   <div class=" text-gray-800">
                     <span class=" font-semibold"><i class="fas fa-star"></i> {{ app()->getLocale() == 'ha' ? 'Daraja' : 'Reputation' }} :   ★★★★☆</span>
                      (12 {{ app()->getLocale() == 'ha' ? 'Kima ' : 'reviews' }})
                   </div>
                  <!-- Language  -->
                   <div class=" text-gray-800">
                     <span class=" font-semibold"><i class="fas fa-language"></i> {{ app()->getLocale() == 'ha' ? 'Halshi' : 'Language' }}</span>
                      {{ $user->language}}
                   </div>
             </div>
             <!-- الأدوات المدرجة -->
              <div class="mt-6">
                <h2 class=" text-xl font-semibold mb-4">
                    <i class="fas fa-tools"></i>{{ app()->getLocale() == 'ha' ? 'Kayan Aiki Na ' : 'My Listed Tools ' }}
                </h2>
                @forelse ($tools as $tool )
                <a href="{{ route('tools.show', $tool->id) }}" class="hover:underline">
                    <p class=" text-gray-800">
                        - {{ $tool->name }}
                        @if ($tool->is_free)
                        [{{ app()->getLocale() == 'ha' ? 'Kyauta ' : 'Free' }}]
                        @else
                        [{{ app()->getLocale() == 'ha' ? 'Biya ' : 'Paid ' }}]
                        @endif
                        <i class="fas fa-eye mr-2"></i>
                    </p>
                </a>
                @empty
                 <p class=" text-gray-600">
                    {{ app()->getLocale() == 'ha' ? 'Baba kayan aiki da ka jera.' : 'No tools listed' }}
                 </p>
                @endforelse
              </div>
              <!-- Buttons -->
               <div class=" mt-6 flex space-x-4">
                @if ($isOwnProfile)
                <a href="{{ route('tools.add') }}" class=" bg-blue-700 text-white p-3 rounded-lg hover:bg-blue-800">
                    <i class="fas fa-add "></i> {{ app()->getLocale() == 'ha' ? 'Qara kayan akik ' : 'Add Tool' }}
                </a>
                <a href="{{ route('profile.edit') }}" class=" bg-yellow-700 text-white p-3 rounded-lg hover:bg-yellow-800">
                    <i class="fas fa-edit"></i>  {{ app()->getLocale() == 'ha' ? 'Gyara Bayanan Ka' : 'Edit Profile' }}
                </a>
                <a href="{{ route('logout') }}" class=" bg-red-500 text-white p-3 rounded-lg hover:bg-red-700">
                    <i class="fas fa-sign-out-alt"></i> {{ app()->getLocale() == 'ha' ? 'Fita' : 'Logout ' }}
                </a>
                @else
                <a href="#" class=" bg-yellow-700 text-gray-100 p-3 rounded-lg hover:bg-yellow-800" desabled>
                    <i class="fas fa-envelope"></i> {{ app()->getLocale() == 'ha' ? 'Chat' : 'Chat ' }}
                </a>
                @endif
               </div>
        </div>
    </div>
</div>
