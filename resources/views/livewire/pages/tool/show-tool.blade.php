<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class=" container mx-auto py-10">
        <div class=" bg-gradient-to-r from-orange-200 to-yellow-100 rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
            <h1 class=" text-3xl font-bold mb-6 flex items-center"><span class="mr-2"><i class="fas fa-tools"></i></span>
            {{ app()->getLocale() == 'ha' ? 'Bayanai - ' : 'Details - '  }} {{ $tool->name }}
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
        <!-- معرض الصور -->
         <div class="mb-6">
            @if ($tool->image_paths && count($tool->image_paths) > 0)
                <div class=" relative">
                    @foreach ($tool->image_paths as $image)
                        <img src="{{ asset('storage/tools' . $image) }}" alt="{{ $tool->name }}">                        
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
                    {{ $tool->rental_price ?? '0.00'  }}/ {{  app()->getLocale() == 'ha' ? 'Rana' : 'Day' }}
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
                <a href="{{ route('profile', $tool->user->id) }}" class="hover:underline">
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
           <p class="text-gray-800 mt-2">
                    {{ app()->getLocale() == 'ha' ? 'Daraja' : 'Reputation' }}:
                    ★★★★☆
                </p>

          <!-- زر طلب الإستعارة ?Borrowed submit -->
          <div class="mt-6">
            <a href="{{ route('tools.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        {{ app()->getLocale() == 'ha' ? 'Komawa' : 'Back' }}
            </a>
          @if (auth()->check() && $tool->user_id !== auth()->id())
            @if ($tool->status == 'available')
            <form wire:submit.prenent="rental({{ $tool->id }})" class=" space-y-4">
                <div>
                    <label for="borrow_date" class=" block text-gray-800 font-semibold">
                        <i class="fas fa-calender-alt mr-2"></i>{{ app()->getLocale() ==  'ha' ? 'Ranar Aro' : 'Borrow Date' }}
                    </label>
                    <input type="date" id="borrow_date" wire:model="borrow_date" class=" w-full p-2 border rounded">
                    @error('borrow_date') <span class=" text-red-500 bg-red-100 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="return_date" class=" block text-gray-800 font-semibold">
                        <i class="fas fa-calender-alt mr-2"></i>{{ app()->getLocale() ==  'ha' ? 'Ranar Mayarwa' : 'Return Date' }}
                    </label>
                    <input type="date" id="return_date" wire:model="return_date" class=" w-full p-2 border rounded">
                    @error('return_date') <span class=" text-red-500 bg-red-100 text-sm">{{ $message }}</span> @enderror
                </div>
                <button class=" bg-yellow-700 text-white p-3 rounded-lg w-full hover:bg-yellow-900">
                  <i class="fas fa-shopping-cart mr-1"></i>  {{  app()->getLocale() == 'ha' ? 'Neman Aro' : 'Request to Borrow' }}
                </button>
            </form>
                 @else    
                <button class=" bg-yellow-800 text-gray-50 py-2 px-4  hover:bg-yellow-950  p-3 rounded-lg w-full cursor-not-allowed" disabled>
                   <i class="fas fa-shoping-cart mr-1"></i> {{  app()->getLocale() == 'ha' ? 'Ba a Samu Ba' : 'Not Available' }}
                </button> 
            @endif
              @elseif(auth()->check() && $tool->user_id === auth()->id())
                 <a href="{{ route('tools.edit', $tool->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 ml-2 hover:underline">
                            <i class="fas fa-edit mr-1"></i>
                            {{ app()->getLocale() == 'ha' ? 'Gyara' : 'Edit' }}
                 </a>
                  <button wire:click="deleteTool({{ $tool->id }})" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2 hover:underline" onclick="return confirm('{{ app()->getLocale() == 'ha' ? 'Shin da gaske ne ka so share wannan kayan aiki?' : 'Are you sure you want to delete this tool?' }}')">
                            <i class="fas fa-trash mr-1"></i>
                            {{ app()->getLocale() == 'ha' ? 'Share' : 'Delete' }}
                  </button>
            @else
              <p class="text-red-500">{{ app()->getLocale() == 'ha' ? 'Da fatan za a shiga don neman aro.' : 'Please login to request a rental.' }}</p>
           @endauth
          </div>
          <!-- Comments -->
          <div class="mt-8">
            <h1 class="text-2xl font-bold mb-4">{{ app()->getLocale() == 'ha' ?  'Bar Tsoka' : 'Leave a Comment' }}</h1>
            <!-- add comment form -->
            @if (auth()->check())
                <form wire:submit.prevent="addComment" class="mb-6" >
                    <textarea wire:model="newComment" class=" w-full p-2 border rounded" rows="2" placeholder="{{ app()->getLocale() == 'ha' ? 'Rubuta sharhi...' : 'Write a comment...'}}" id=""></textarea>
                    @error('newComment')  <span class=" text-red-500 bg-red-100 text-sm">{{ $message }}</span>  @enderror
                    <button type="submit" class="  bg-yellow-800 text-gray-200 py-2 px-4  hover:bg-yellow-950   p-2 rounded mt-2" >
                        {{ app()->getLocale() == 'ha' ? 'Ajiye' : 'Submit' }}
                    </button>
                </form>
            @endif
            <!-- Show Comments -->
             @forelse ($tool->comments as $comment )
                <div class="border-b py-4">
                    <div class=" flex items-center mt-2">
                        <p class=" font-semibold"> {{ app()->getLocale() == 'ha' ? 'Ta' : 'By' }} {{ $comment->user->name }}</p>
                        <small class="text-gray-600 ml-2">{{ $comment->created_at->diffForHumans() }}</small>
                        <p>{{ $comment->content }}</p>
                    </div>
                </div>
             @empty 
                 <p class=" text-gray-700">{{ app()->getLocale() == 'ha' ? 'Baba sharhi tukuna.' : 'No Comment' }}</p>
             @endforelse
          </div>
        </div>
    </div>
</div>
