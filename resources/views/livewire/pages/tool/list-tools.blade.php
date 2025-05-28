<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="  p-6 rounded-lg shadow-lg mb-6">
    <h1 class=" text-3xl font-bold mb-6 text-center ">{{ app()->getLocale() == 'ha' ? 'Kayan Aiki' : 'Tools' }}</h1>
         <!-- الفلاتر -->
        
            
            <div class=" grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- الفلترة )(على الجانب الايسر) -->
                <div x-data="{open: false}" class="md:col-span-1">
                      <!-- زرالفلترة على الجوال -->
                    <button @click="open = !open" class=" md:hidden w-full bg-blue-500 text-yellow-50 p-2 rounded mb-4 flex items-center justify-center"><i class="fas fa-filter mr-2" ></i>{{ app()->getLocale() == 'ha' ? 'Tach' : 'Filter' }} </button>
                    <!-- خيارات الفلترة -->
                    <div x-show="open" x-transition class="md:block bg-blue-300 p-4 rounded-lg"><h2 class=" text-xl font-semibold mb-4 flex items-center "><i class=" fas fa-compass mr-2"></i> {{ app()->getLocale() == 'ha' ? 'Tace' : 'Filter' }}   </h2>
                        <!-- location الموقع -->
                        <div class="mb-4"> 
                          <label for="location" class=" block text-gray-900 font-semibold">{{ app()->getLocale() == 'ha' ? 'Wuri' : 'Location' }}</label>
                         <input type="text" id="location" wire:model.debounce.500ms="location" class=" w-full p-2 border rounded" placeholder="{{ app()->getLocale() == 'ha' ? 'Shiga da wuri' : 'Enter location' }}">
                        </div>
                             <!-- الفئة -->
                        <div class=" mb-4">
                            <label for="category_id"> {{ app()->getLocale() == 'ha' ? 'Rukuni ku Nau\'i' : 'Select Category' }} </label>
                            <select id="category_id" wire:model.lazy="category_id" class=" w-full p-2 border rounded">
                                <option value="">{{ app()->getLocale() == 'ha' ? 'Zabi rukuni ko duk' : 'Select category or all' }}</option>
                                @foreach ($categories as $category )
                                <option value="{{ $category->id }}">{{ $category->localized_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- price -->
                        <div class=" mb-4">
                            <label for="price_max">
                                {{ app()->getLocale() == 'ha' ? 'Rukuni ku Nau\'i' : 'Select Category' }}
                            </label>
                            <select id="price_max" wire:model.lazy="price_max" class=" w-full p-2 border rounded">
                                <option value="">{{ app()->getLocale() == 'ha' ? 'Zabi Farashi' : 'Price' }}</option>
                                <option value="500">{{ app()->getLocale() == 'ha' ? '< 500N' : '< 500N' }}</option>
                                <option value="1000">{{ app()->getLocale() == 'ha' ? '< 1000N' : '< 1000N' }}</option>
                                <option value="2000">{{ app()->getLocale() == 'ha' ? '< 2000N' : '< 2000N' }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        
 <!-- عرض الأدوات -->
<div class="md:col-span-2 space-y-4 mt-6">
    @forelse ($tools as $tool)
        <div class="bg-white p-4 rounded-lg shadow flex items-start space-x-4">
            <!-- صورة صغيرة -->
            <div class="w-24 h-24 flex-shrink-0">
                @if ($tool->image_paths && count($tool->image_paths) > 0 )
                    <img src="{{ asset('storage/' . $tool->image_paths[0]) }}" alt="{{ $tool->name }}" class="w-full h-full object-cover rounded">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded">
                        <span class="text-gray-800 text-sm text-center">
                            {{ app()->getLocale() == 'ha' ? 'Babu hoto' : 'No image' }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- تفاصيل الأداة -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold flex items-center mb-1">
                    <i class="fas fa-tools mr-2"></i>
                    {{ $tool->name }} 
                    ({{ $tool->is_free ? (app()->getLocale() == 'ha' ? 'Kyauta' : 'Free') : 'N' . $tool->price . '/' . (app()->getLocale() == 'ha' ? 'Rana' : 'Day') }})
                </h3>

                <p class="text-gray-900 mb-2 flex items-center">
                    <i class="fas fa-map mr-2"></i>
                    {{ $tool->location }} - 
                    ({{ app()->getLocale() == 'ha' ? 'Daraja' : 'Reputation' }}: *****)
                </p>

                <a href="{{ route('tools.show', $tool->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-800 inline-flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    {{ App()->getLocale() == 'ha' ? 'Bayani' : 'Show details' }}
                </a>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-800">
            {{ app()->getLocale() == 'ha' ? 'Ba kayan aiki da aka samu.' : 'No tools found' }}
        </p>
    @endforelse
</div>


</div>
</div>
   
   
        
            
              
                
                    
          
     
          
    