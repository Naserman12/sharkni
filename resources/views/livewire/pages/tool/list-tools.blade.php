<div class=" container mx-auto py-10">
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="p-6 rounded-lg shadow-lg">
    <h1 class=" text-3xl font-bold mb-6 text-center "><i class="fas fa-search mr-2"></i> {{ app()->getLocale() == 'ha' ? 'Ado Available don Aro/Kira' : 'Tools availabel for Borrowing/Reting' }}
     @if ($selected_category)
            <span class=" text-xl ml-2">- {{ app()->getLocale() == 'ha' ? $selected_category->name_ha : $selected_category->name }}</span>
     @endif
    </h1>
         <!-- الفلاتر -->    
            <div x-data="filterComponent()" x-init="init()" class="filters-container" class=" space-y-6">
                  <button @click="toggle()" class="btn-toggle-filters">
                        <span x-text="isOpen ? 'إخفاء الفلاتر' : 'إظهار الفلاتر'"></span>
                 </button>
                <!-- الفلترة )(على الجانب الايسر) -->
                <div x-data="{open: false}" class=" w-full">
                      <!-- زرالفلترة على الجوال -->
                    <button @click="open = !open" class="md:hidden w-full bg-blue-500 text-yellow-50 p-2 rounded mb-4 flex items-center justify-center"><i class="fas fa-filter mr-2" ></i>{{ app()->getLocale() == 'ha' ? 'Tach' : 'Filter' }} </button>
                    <!-- خيارات الفلترة -->
                    <div x-show="isOpen" x-transition class="filters-panel" class="bg-blue-300 p-4 rounded-lg block md:flex md:space-x-4 md:space-y-0 mb-4" :class="{'hidden': !open, 'block': open}"><h2 class=" text-xl font-semibold mb-4 flex items-center md:hidden "><i class=" fas fa-compass mr-2"></i> {{ app()->getLocale() == 'ha' ? 'Tace' : 'Filter' }}   </h2>
                        <!-- location الموقع -->
                        <div class="md:flex md:items-center md:space-x-2 "> 
                          <label for="location" class="block text-gray-900 font-semibold md:mr-2">{{ app()->getLocale() == 'ha' ? 'Wuri' : 'Location' }}</label>
                         <input type="text" id="location" wire:model.debounce.500ms="location" class=" w-full md:w-48 p-2 border rounded" placeholder="{{ app()->getLocale() == 'ha' ? 'Shiga da wuri' : 'Enter location' }}">
                        </div>
                             <!-- الفئة -->
                        <div x-data="{open: false}" class=" md:flex md:items-center md:space-x-2 ">
                            <button @click="open= !open" class="text-gray-900 p-2 rounded" >{{ app()->getLocale() == 'ha' ? 'Rukuni ku Nau\'i' : 'Select Category' }}</button>
                            <!-- <label class="block  font-semibold md:mr-2" for="category_slug"> {{ app()->getLocale() == 'ha' ? 'Rukuni ku Nau\'i' : 'Select Category' }} </label> -->
                             <div class="mt-2 bg-blue-300 p-4 rounded">

                                 <select id="category_slug" @change="if($event.target.value) { window.location.href ='/tools/category/' + $event.target.value} else {window.location.href = '/tools'}" class=" w-full  md:w-48 p-2 border rounded">
                                     <option value="">{{ app()->getLocale() == 'ha' ? 'Zabi rukuni ko duk' : 'Select category or all' }}</option>
                                     @foreach ($categories as $category )
                                     <option value="{{ $category->slug }}">{{ $category->localized_name}}</option>
                                     @endforeach
                                 </select>
                             </div>
                            @if ($category_slug)
                                <button wire:click="resetCategoryFilter" class=" mt-2 text-red-500 hover:underline">
                                    {{ app()->getLocale() == 'ha' ? 'Share' : 'Clear Category' }}
                                </button>
                            @endif
                        </div>
                        <!-- price -->
                        <div class=" md:flex md:items-center md:space-x-2 ">
                            <label for="price_max">
                                {{ app()->getLocale() == 'ha' ? 'Rukuni ku Nau\'i' : 'Select Category' }}
                            </label>
                            <select id="price_max" wire:model.lazy="price_max" class=" w-full  md:w-48 p-2 border rounded">
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
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @forelse ($tools as $tool)
        <div class="flex items-center border-b md:border  md:rounded-lg md:shadow-sm  md:p-4 py-4 bg-gray-100 ">
            <!-- صورة صغيرة -->
            <div class="w-24 h-24 mr-4">
                @if ($tool->image_paths && count($tool->image_paths) > 0 )
                    <img src="{{ asset('storage/' . $tool->image_paths[0]) }}" alt="{{ $tool->name }}" class="w-full h-full object-cover rounded-lg">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded-lg">
                        <span class="text-gray-800 text-sm text-center">
                            {{ app()->getLocale() == 'ha' ? 'Babu hoto' : 'No image' }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- تفاصيل الأداة -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-tools mr-2"></i>
                    {{ $tool->name }} 
                    ({{ $tool->is_free ? (app()->getLocale() == 'ha' ? 'Kyauta' : 'Free') : 'N' . $tool->price . '/' . (app()->getLocale() == 'ha' ? 'Rana' : 'Day') }})
                </h3>

                <a href="{{ route('tools.show', $tool->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-800 inline-flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    {{ App()->getLocale() == 'ha' ? 'Bayani' : 'Show details' }}
                </a>
                <p class="text-gray-900 mt-1 flex items-center">
                    <i class="fas fa-map mr-2"></i>
                    {{ $tool->location }} - 
                    ({{ app()->getLocale() == 'ha' ? 'Daraja' : 'Reputation' }}: *****)
                </p>

            </div>
        </div>
    @empty
        <p class="text-center text-gray-800">
            {{ app()->getLocale() == 'ha' ? 'Ba kayan aiki da aka samu.' : 'No tools found' }}
        </p>
    @endforelse
</div>

<div class="mt-6">
    {{ $tools->links() }}
</div>
</div>
</div>
   
   
        
            
              
                
                    
          
     
          
    