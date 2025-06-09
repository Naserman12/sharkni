
    <div class=" min-h-screen flex items-center justify-center py-10">
       <div class="w-full max-w-md  mx-auto bg-gradient-to-r from-orange-300  px-4">
            <h2 class="text-2xl font-bold mb-6 text-center">
                {{ app()->getLocale() == 'ha' ? 'Qara Kayan Aiki ': 'Add A Tool'}}
            </h2>
            <!-- messages -->
         @if (session('message'))
         <div class=" mb-4 p-2 bg-green-200 text-green-700">
             {{ session('message') }} 
            </div>
         @endif
        <!-- Error messages  -->
         @error('form')  
         <div class=" mb-4 p-2 bg-red-200 text-red-700">
             {{ $message }} 
            </div>
         @enderror
         
         <form wire:submit.prevent="addTool">
            @csrf
            <!-- Category -->
            <div class=" mb-4">
                <label for="category_id" class=" block text-gray-900">
                    {{ app()->getLocale() == 'ha' ? 'Rukuni': 'Category'}}
                </label>
                <select wire:model="category_id" id="category_id" class=" w-full p-2 border rounded">
                    <option value="">{{ app()->getLocale() == 'ha' ? 'Zabi rukuni ': 'Select a category'}}</option>
                    @foreach ($categories as $category)
                    <option class=" text-blue-700" value="{{ $category->id }}">{{ $category->localized_name ?? 'babu suan' }}</option>  
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>
                @enderror
             </div>
            <!-- Name -->
            <div class=" mb-4">
                <label for="name" class=" block text-gray-900">
                    {{ app()->getLocale() == 'ha' ? 'Suanan kayan aiki ': 'Tool Name'}}
                </label>
                <input type="text" wire:model="name" id="name" class=" w-full p-2 border rounded">
                @error('name')
                    <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>
                @enderror
             </div>
             <!-- Description -->
             <div class=" mb-4">
                <label for="description" class=" block text-gray-900">
                    {{ app()->getLocale() == 'ha' ? 'Bayann kayan aiki ': 'Tool description'}} ({{ app()->getLocale() == 'ha' ? 'Na zaqi' : 'Optional' }})
                </label>
                <input type="text" wire:model="description" id="description" class=" w-full p-2 border rounded">
                @error('description')
                    <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>
                    @enderror
                </div>
         <!-- images -->
                <div class="mb-4">
                    <label for="images" class=" block text-gray-900">
                        {{ app()->getLocale() == 'ha' ? 'Hotunan kayan aiki ': 'Tool Image'}}
                    </label>
                     <div class=" relative">
                        <button type="button" onclick="document.getElementById('images').click()" class=" bg-blue-600 text-gray-200 px-4 py-2 rounded hover:bg-blue-700 flex items-center">
                            <i class="fas fa-image mr-2"></i>
                            {{ app()->getLocale() == 'ha' ? 'Zabi Hotuna ' : 'Choose Images ' }}
                        </button>
                        <input type="file" id="images" wire:model="images" multiple class="hidden" accept="image/*">
                    </div>
                      <!-- عرض اسما الصور المختارة -->
                    <div class=" mt-2">
                        @if ($images)
                            @foreach ($images as $image)
                                <p class=" text-gray-700 text-sm">{{ $image->getClientOriginalName() }}</p>
                            @endforeach
                        @endif
                    </div>
                    @error('images')
                    <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>      
                    @enderror
                    @error('images.*')
                    <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>      
                    @enderror
                </div>
                <!-- Is Free -->
                <div class=" mb-4">
                    <label class=" block text-gray-800 font-semibold">
                        {{ app()->getLocale() == 'ha' ? 'Tsari na Farashi': 'Price Option'}}
                    </label>
                    <div class=" flex items-center space-x-4 mb-2">
                        <label for="is_free" class=" block text-gray-900">
                            <input type="radio" wire:model.lazy="is_free" value="1" id="is_free" class="  mr-2">
                            {{ app()->getLocale() == 'ha' ? 'Kyauta': 'Free'}}
                        </label>
                        <label for="is_free" class=" block text-gray-900">
                            <input type="radio" wire:model.lazy="is_free" value="0" id="is_free" class="  mr-2">
                            {{ app()->getLocale() == 'ha' ? 'Da Farashi': 'Is paid'}}
                        </label>
                    </div>
                    @error('is_free')
                        <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>
                     @enderror
                    </div>
                @if(!$is_free)
                <!-- Price per day -->
                <div class=" mb-4">
                    <label for="rental_price" class=" block text-gray-900 font-semibold">
                        {{ app()->getLocale() == 'ha' ? 'Farashin Kowace Rana ': 'Price Per Day'}}
                    </label>
                    <input type="number" step="0.01" min="0" wire:model="rental_price" id="rental_price" class=" w-full p-2 border rounded" placeholder="{{ app()->getLocale() == 'ha' ? 'Saka Farashi' : 'Enter price'}}">
                    @error('rental_price')
                        <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
                    <!-- Deposit Amount-->
                <div class=" mb-4">
                    <label for="deposit_amount" class=" block text-gray-900">
                        {{ app()->getLocale() == 'ha' ? 'Adadin Ajiya': 'Deposit Amount'}}
                    </label>
                    <input type="number" min="0" wire:model="deposit_amount" id="deposit_amount" class=" w-full p-2 border rounded">
                    @error('deposit_amount')
                        <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>
                        @enderror
                </div>
                    <!-- Status-->
                    <div class=" mb-4">
                        <label for="status" class=" block text-gray-900">
                            {{ app()->getLocale() == 'ha' ? 'Matsyi': 'Status'}}
                        </label>
                        <select  wire:model="status" id="status" class=" w-full p-2 border rounded">
                            <option value="available">{{ app()->getLocale() == 'ha' ? 'Akwai' : 'Available' }}</option>
                            <option value="borrowed">{{ app()->getLocale() == 'ha' ? 'An Aro' : 'Borrowed'}}</option>
                            <option value="unavailable">{{ app()->getLocale() == 'ha' ? 'Babu shi': 'Unavailable'}}</option>
                        </select>
                        @error('status')
                        <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>
                        @enderror
                        </div>
                    <!-- Condition-->
                    <div class=" mb-4">
                        <label for="condition" class=" block text-gray-900">
                            {{ app()->getLocale() == 'ha' ? 'Yanayi': 'Condition'}}
                        </label>
                        <select  wire:model="condition" id="condition" class=" w-full p-2 border rounded">
                            <option value="new">{{ app()->getLocale() == 'ha' ? 'Sabu' : 'New' }}</option>
                            <option value="used">{{ app()->getLocale() == 'ha' ? 'An Yi Amfani ' : 'Used'}}</option>
                            <option value="needs_repair">{{ app()->getLocale() == 'ha' ? 'Yana Bukata Gyara ': 'Needs Repair'}}</option>
                        </select>
                        @error('condition')
                        <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Location -->
                    <div class=" mb-4">
                        <label for="location" class=" block text-gray-900">
                            {{ app()->getLocale() == 'ha' ? 'Wurin kayan aiki ': 'Tool location'}}
                        </label>
                        <input type="text" wire:model="location" id="location" class=" w-full p-2 border rounded">
                        @error('location')
                            <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>
                        @enderror
                     </div>
                    <!-- Submit Button -->
                    <div class="mb-4">
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-pink-600 hover:to-purple-600 text-white font-bold py-3 rounded-lg shadow-lg transition" >
                            {{ app()->getLocale() == 'ha' ? 'Qara kayan aiki': 'Add Tool'}}
                        </button>
                     </div>
         </form>
        </div>
    </div>