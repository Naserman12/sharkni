<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class=" container mx-auto py-10">
        <div class=" bg-gray-500 rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
            <h1 class=" text-3xl font-bold mb-6 flex items-center"><span class="mr-2"><i class="fas fa-tools"></i></span>
            {{ app()->getLocale() == 'ha' ? 'Bayanai - ' : 'Details - '  }} {{ $tool->name }}
        </h1>

        <!-- معرض الصور -->
         <div class="mb-6">
            @if ($tool->image_paths && count($tool->image_paths) > 0)
                <div class=" relative">
                    @foreach ($tool->image_paths as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $tool->name }}">                        
                    @endforeach
                </div>
            @else
               <div class=" w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                <span class=" text-gray-800">{{ app()->getLocale() == 'ha' ? 'Babu Hoto' : 'No Image' }}</span>
               </div>
            @endif
         </div>
         <!-- التفاصيل -->
          <div class=" space-y-4">
            <!-- الوصف -->
             <p class=" text-gray-800">
                <span class=" font-semibold"><i class="fas fa-file-alt mr-1"></i>{{  app()->getLocale() == 'ha' ? 'Bayanin' : 'Description' }}</span>
                {{ $tool->description ?? ( app()->getLocale() == 'ha' ? 'Babu Bayanin' : 'No Description') }}
             </p>
             <!-- Price & deposit_amount -->
             <p class=" text-gray-800">
                <span class=" font-semibold"><i class="fas fa-money-bill-wave mr-1"></i> {{  app()->getLocale() == 'ha' ? 'Farashin' : 'Price' }}</span>
                @if ($tool->is_free)
                {{  app()->getLocale() == 'ha' ? 'Kyauta' : 'Free' }}     
                @else
                    {{ $tool->price ?? '0.00'  }}/ {{  app()->getLocale() == 'ha' ? 'Rana' : 'Day' }}
                @endif
                |<span class=" font-semibold">{{  app()->getLocale() == 'ha' ? 'Ajiya' : 'Deposit' }} :</span>
                {{ $tool->deposit_amount ?? '0.00' }}
             </p>
             <!-- Location -->
             <p class=" text-gray-800">
                <span class=" font-semibold"> <i class="fas fa-map mr-1"></i>{{  app()->getLocale() == 'ha' ? 'Wuri' : 'Location' }}:</span>
                {{ $tool->location ?? ( app()->getLocale() == 'ha' ? 'Babu ' : 'None') }}
             </p>
             <!-- condition -->
              <p class=" text-gray-800">
                <span class=" font-semibold"> <i class="fas fa-wrench  mr-1"></i>{{  app()->getLocale() == 'ha' ? 'Yanayi' : 'Condition' }}:</span>
                @if ($tool->condition == 'new')
                    {{  app()->getLocale() == 'ha' ? 'Saboni' : 'New' }}
                @elseif ($tool->condition == 'used')
                    {{  app()->getLocale() == 'ha' ? 'An Yi Amfani' : 'Used' }}
                @else
                    {{  app()->getLocale() == 'ha' ? 'Yana Bukatar Gyara' : 'Needs Repair' }}
                @endif
              </p>
              <!-- Owner -->
               <p class=" text-gray-800">
                <span class=" font-semibold"> <i class="fas fa-user mr-1"></i>{{  app()->getLocale() == 'ha' ? 'Mai Shi' : 'Owner' }}:</span>
                <a href="{{ route('profile', $tool->user->id) }}" class="  bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-700 hover:underline">
                    {{ $tool->user->name ?? ( app()->getLocale() == 'ha' ? 'Babu Bayanin' : 'No Information') }}
                </a>
               </p>
               <!-- Status -->
                <p class=" text-gray-800">
                    <span class=" font-semibold"> <i class="fas fa-calender-check mr-1"></i> {{  app()->getLocale() == 'ha' ? 'Mastayi' : 'Status' }}:</span>
                    @if ($tool->status == 'available')
                        {{  app()->getLocale() == 'ha' ? 'Akwai' : 'Available' }}     
                    @elseif ($tool->status == 'borrowed')
                        {{  app()->getLocale() == 'ha' ? 'An  Aro' : 'Borrowed' }}
                    @else
                        {{  app()->getLocale() == 'ha' ? 'Babu' : 'Unavailable' }}
                    @endif
                </p>
          </div>

          <!-- زر طلب الإستعارة ?Borrowed submit -->
          <div class="mt-6">
            @if ($tool->status == 'available')
                <button class=" bg-blue-500 text-white p-3 rounded-lg w-full hover:bg-blue-700">
                  <i class="fas fa-shopping-cart mr-1"></i>  {{  app()->getLocale() == 'ha' ? 'Neman Aro' : 'Request to Borrow' }}
                </button>
                @else
                <button class=" bg-gray-800 text-white p-3 rounded-lg w-full hover:bg-gray-700 cursor-not-allowed" disabled>
                   <i class="fas fa-shoping-cart mr-1"></i> {{  app()->getLocale() == 'ha' ? 'Ba a Samu Ba' : 'Not Available' }}
                </button>     
            @endif
          </div>
        </div>
    </div>
</div>
