<div class="container mx-auto py-10">
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class=" bg-orange-300 rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h1 class=" text-3xl font-bold mb-6 flex items-center ">
             <i class="fas fa-edit mr-2"></i>
            {{ app()->getLocale() == 'ha' ? 'Gyara Kayan Aiki' : 'Edit Tool' }}
        </h1>
        <!-- messages -->
          @if (session('message'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                {{ session('message') }}
            </div>
        @endif
        <form wire:submit.prevent="updateTool" class="space-y-4" enctype="multipart/form-data">
              <!-- الاسم -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Sunan Kayan Aiki' : 'Tool Name' }}
                </label>
                <input type="text" id="name" wire:model="name" class="w-full p-2 border rounded">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
               <!-- الوصف -->
            <div>
                <label for="description" class="block text-gray-700 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Bayani' : 'Description' }}
                </label>
                <textarea id="description" wire:model="description" class="w-full p-2 border rounded" rows="4"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
             <!-- السعر أو مجاني -->
            <div>
                <label class="block text-gray-700 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Tsari na Farashi' : 'Pricing Option' }}
                </label>
                <div class="flex items-center space-x-4 mb-2">
                    <label class="flex items-center">
                        <input type="radio" wire:model="is_free" value="1" class="mr-2">
                        {{ app()->getLocale() == 'ha' ? 'Kyauta' : 'Free' }}
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="is_free" value="0" class="mr-2">
                        {{ app()->getLocale() == 'ha' ? 'Da Farashi' : 'Paid' }}
                    </label>
                </div>
                @if (!$is_free)
                    <div>
                        <label for="rental_price" class="block text-gray-700 font-semibold">
                            {{ app()->getLocale() == 'ha' ? 'Farashin Hayar (₦)' : 'Rental Price (₦)' }}
                        </label>
                        <input type="number" id="rental_price" wire:model="rental_price" step="0.01" class="w-full p-2 border rounded" placeholder="{{ app()->getLocale() == 'ha' ? 'Saka farashin hayar' : 'Enter rental price' }}" min="0">
                        @error('rental_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif
            </div>
             <!-- مبلغ التأمين -->
            <div>
                <label for="deposit_amount" class="block text-gray-700 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Adadin Ajiya (₦)' : 'Deposit Amount (₦)' }}
                </label>
                <input type="number" id="deposit_amount" wire:model="deposit_amount" step="0.01" class="w-full p-2 border rounded" placeholder="{{ app()->getLocale() == 'ha' ? 'Saka adadin ajiya' : 'Enter deposit amount' }}" min="0">
                @error('deposit_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
              <!-- الموقع -->
            <div>
                <label for="location" class="block text-gray-700 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Wuri' : 'Location' }}
                </label>
                <input type="text" id="location" wire:model="location" class="w-full p-2 border rounded" placeholder="{{ app()->getLocale() == 'ha' ? 'Fagge' : 'Fagge' }}">
                @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
              <!-- الفئة -->
            <div>
                <label for="category_id" class="block text-gray-700 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Nau\'i' : 'Category' }}
                </label>
                <select id="category_id" wire:model="category_id" class="w-full p-2 border rounded">
                    <option value="">{{ app()->getLocale() == 'ha' ? 'Zabi Nau\'i' : 'Select Category' }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>
                            {{ app()->getLocale() == 'ha' ? $category->name_ha : $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
             <!-- الصور -->
            <!-- <div>
                <label for="image_paths" class="block text-gray-700 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Hotuna' : 'Images' }}
                </label>
                <input type="file" id="image_paths" wire:model="image_paths" multiple class="w-full p-2 border rounded">
                @error('image_paths') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div> -->
             <!-- images -->
                <div class="mb-4">
                    <label for="image_paths" class=" block text-gray-900">
                        {{ app()->getLocale() == 'ha' ? 'Hotunan kayan aiki ': 'Tool Image'}}
                    </label>
                     <div class=" relative">
                        <button type="button" onclick="document.getElementById('image_paths').click()" class=" bg-blue-600 text-gray-200 px-4 py-2 rounded hover:bg-blue-700 flex items-center">
                            <i class="fas fa-image mr-2"></i>
                            {{ app()->getLocale() == 'ha' ? 'Zabi Hotuna ' : 'Choose Images ' }}
                        </button>
                        <input type="file" id="image_paths" wire:model="image_paths" multiple class="hidden" accept="image/*">
                    </div>
                      <!-- عرض اسما الصور المختارة -->
                    <div class=" mt-2">
                        @if ($images)
                            @foreach ($images as $image)
                                <p class=" text-gray-700 text-sm">{{ $image->getClientOriginalName() }}</p>
                            @endforeach
                        @endif
                    </div>
                    @error('image_paths')
                    <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>      
                    @enderror
                    @error('image_paths.*')
                    <span class="text-sm text-red-600 bg-red-200">{{ $message }}</span>      
                    @enderror
                </div>
            <!-- الأزرار -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white p-3 rounded-lg w-full hover:bg-blue-600 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    {{ app()->getLocale() == 'ha' ? 'Ajiye Canje-canje' : 'Save Changes' }}
                </button>
                <button type="button" wire:click="deleteTool" class="bg-red-500 text-white p-3 rounded-lg w-full hover:bg-red-600 flex items-center justify-center" onclick="return confirm('{{ app()->getLocale() == 'ha' ? 'Shin da gaske ne ka so share wannan kayan aiki?' : 'Are you sure you want to delete this tool?' }}')">
                    <i class="fas fa-trash mr-2"></i>
                    {{ app()->getLocale() == 'ha' ? 'Share' : 'Delete' }}
                </button>
            </div>
        </form>
    </div>
</div>
