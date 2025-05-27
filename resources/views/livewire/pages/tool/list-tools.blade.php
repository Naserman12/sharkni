<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class=" bg-slate-600 p-6 rounded-lg shadow-lg mb-6">
        <h1 class=" text-3xl font-bold mb-6 text-center ">
            {{ app()->getLocale() == 'ha' ? 'Kayan Aiki' : 'Tools' }}
        </h1>
        <!-- الفلاتر -->
        <div class=" bg-slate-600 rounded-lg shadow-lg mb-6">
            <h2 class=" text-lg font-semibold mb-4" >
                {{ app()->getLocale() == 'ha' ? 'Nema da Rarraba' : 'Search & Filter' }}
            </h2>
            <div class=" grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- الفئة -->
                <div class="">
                    <label for="category_id">
                        {{ app()->getLocale() == 'ha' ? 'Rukuni' : 'Category' }}
                    </label>
                    <select id="category_id" wire:model.lazy="category_id" class=" w-full p-2 border rounded">
                        <option value="">{{ app()->getLocale() == 'ha' ? 'Zabi rukuni ko duk' : 'Select category or all' }}</option>
                        @foreach ($categories as $category )
                        <option value="{{ $category->id }}">{{ $category->localized_name}} </option>
                        @endforeach
                    </select>
                 </div>
                 <!-- location الموقع -->
                 <div class=""> 
                     <label for="location" class=" block text-gray-900">
                        {{ app()->getLocale() == 'ha' ? 'Wuri' : 'Location' }}
                    </label>
                    <input type="text" id="location" wire:model.debounce.500ms="location" class=" w-full p-2 border rounded" placeholder="{{ app()->getLocale() == 'ha' ? 'Shiga da wuri' : 'Enter location' }}">
                </div>
                
                <!-- status الحالة -->
                <div class="">
                    <label for="status" class="  block text-gray-800">
                        {{ app()->getLocale() == 'ha' ? 'Mastayi' : 'Status' }}
                    </label>
                <select id="status" wire:model.lazy="status" class=" w-full p-2 border rounded">
                    <option value="">{{ app()->getLocale() == 'ha' ? 'Duk' : 'All' }}</option>
                    <option value="available">{{ app()->getLocale() == 'ha' ? 'Akwai' : 'Available' }}</option>
                    <option value="borrowed">{{ app()->getLocale() == 'ha' ? 'An Aro' : 'Borrowed' }}</option>
                    <option value="unavailable">{{ app()->getLocale() == 'ha' ? 'Babu' : 'Unavailable' }}</option>
                </select>
                  </div>
            </div>
         </div>
         <!-- عرض الادوات -->
         @forelse ($tools as $tool)
          <div class=" grid grid-cols-1 sm:grid-cols-2  lg:grid-cols-4 gap-6">
            <div class=" bg-gray-500 rounded-lg shadow-lg p-4">
                <!-- Images -->
                 @if ($tool->image_paths && count($tool->image_paths) > 0)
                 <img src="{{ asset('storage/' . $tool->image_paths[0]) }}" alt="{{ $tool->name }}" class=" w-full h-40 object-cover rounded-lg mb-4">
                 @else
                 <div class=" w-full h-40 bg-gray-200  rounded-lg mb-4 flex items-center justify-center ">
                    <span class=" text-gray-800">  {{ app()->getLocale() == 'ha' ? 'Babu hoto' : 'No image' }}</span>
                 </div>
                 @endif
                 <!-- Tool name اسم الاداة -->
                  <h3 class=" text-lg font-semibold mb-2"> {{ $tool->name}} || {{ $status }}</h3>
                 <!-- category -->
                  <p class=" text-gray-800 mb-1"> 
                    {{ app()->getLocale() == 'ha'? 'Rukuni': 'Category' }}:|<strong> {{ $tool->category->localized_name }}</strong>
                  </p>
                 <!-- Price -->
                  <p class=" text-gray-800 mb-1"> 
                    {{ app()->getLocale() == 'ha'? 'Farashin': 'Price' }}:|
                    @if ($tool->is_free)
                        <strong>{{ app()->getLocale() == 'ha' ? 'Kyauta': 'Free' }}</strong>
                   @else
                   {{ $tool->price }}:| {{ app()->getLocale() == 'ha' ? 'Kowane Rana': 'Per Day' }}
                   @endif
                </p>
                <!-- Categoty -->
                 <p class=" text-gray-800 mb-1">
                     {{ app()->getLocale() == 'ha' ? 'Lambar Rukuni': 'Category ID' }}:|
                  <strong>{{ $tool->category_id ??  (app()->getLocale() == 'ha' ? 'Babu': 'None' )}} </strong>
                 </p>
                <!-- Location -->
                 <p class=" text-gray-800 mb-1">
                     {{ app()->getLocale() == 'ha' ? 'Wuri': 'Location' }}:|
                  <strong>{{ $tool->location ??  (app()->getLocale() == 'ha' ? 'Babu': 'None' )}} </strong>
                 </p>
                <!-- deposit amount  المبلغ المستودع -->
                 <p class=" text-gray-800 mb-1">
                     {{ app()->getLocale() == 'ha' ? 'Adadin Ajiya': 'Deposit' }}:|
                  <strong>{{ $tool->deposit_amountc ? $tool->deposit_amount : (app()->getLocale() == 'ha' ? 'Babu': 'None' )}} </strong>
                 </p>

                 <!-- Condition -->
                 <p class=" text-gray-800 mb-1">
                     {{ app()->getLocale() == 'ha' ? 'Yanayi': 'Condition' }}:|
                     @if ($tool->condition == 'new')
                     <strong> {{ app()->getLocale() == 'ha' ? 'Sabu': 'New'}} </strong>
                     @elseif ($tool->condition == 'used') 
                     <strong>  {{ app()->getLocale() == 'ha' ? 'An Yi Amfani': 'Used'}} </strong>
                     @else
                     <strong>{{ app()->getLocale() == 'ha' ? 'Yana Bukatar Gyara': 'Needs Repair'}} </strong>      
                     @endif
                    </p>
                    <!-- Is available حالة التوفر -->
                    <p class=" text-gray-800 mb-1">
                        {{ app()->getLocale() == 'ha' ? 'Mastayi': 'Status' }}: 
                        @if ($tool->status == 'available')
                        <strong>{{ app()->getLocale() == 'ha' ? 'Akwai': 'Available'}} </strong>
                     @elseif ($tool->status == 'borrowed') 
                     <strong>{{ app()->getLocale() == 'ha' ? 'An Aro': 'Borrowed'}} </strong>
                     @else
                     <strong> {{ app()->getLocale() == 'ha' ? 'Babu': 'Unavailable'}} </strong>
                     @endif
                 </p>
                 <a href="#" class=" block mt-4 bg-blue-500 text-white text-center p-2 rounded hover:bg-blue-700">
                    {{ app()->getLocale() == 'ha' ? 'Duba Byanai' : 'View Details'}}
                 </a>
            </div>    
            @empty
            <div class=" col-span-full text-center text-gray-800">
                {{ app()->getLocale() == 'ha' ? 'Ba kayan aiki da aka samu. ' : 'No tools found'  }}
            </div>   
            @endforelse
          </div>
    </div>
</div>
