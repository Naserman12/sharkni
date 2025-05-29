<div class="container mx-auto py-10">
    {{-- Stop trying to control. --}} 
    <div class=" bg-blue-200 rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h1 class=" text-gray-900 text-3xl font-bold mb-6 flex items-center">
            <i class="fas fa-exclamation mr-2"></i> 
            {{ app()->getLocale() == 'ha' ? 'Rohoton Lalacewa' : 'Report Damage' }}
        </h1>
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
         <form wire:submit="reportDamage" class="space-y-4">
            <!-- عملية الاستعارة -->
             <div class="">
                <label for="rental_id" class=" block text-gray-800 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Neman Aro' : 'Borrow Request' }}
                </label>
                <select wire:model="rental_id" id="rental_id" class=" w-full p-2 border rounded">
                    <option value="">{{ app()->getLocale() == 'ha' ? 'Zabi Neman Aro' : 'Select Borrow Request' }}</option>
                    @foreach ($rentals as $rental )
                        <option value="{{ $rental->id }}">{{ app()->getLocale() == 'ha' ? 'Neman Aro #'. $rental->id : 'Borrow Request #' .$rental->id}}</option>
                    @endforeach
                </select>
                @error('rental_id') <span class="text-red-500 bg-red-200 text-sm">{{ $message }}</span> @enderror
             </div>

             <!-- وصف الضرر -->
              <div class="">
                <label for="description" class=" block text-gray-900 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Bayanin Lalacewa' : 'Damage Description' }}
                </label>
                <textarea id="description" wire:model="description" class=" w-full p-2 border rounded" rows="4" placeholder="{{ app()->getLocale() == 'ha' ? 'Bayanin Lalacewa (idan akwai)...' : 'Describe the daamage (optional)...' }}"></textarea>
                @error('description') <span class="text-red-500 bg-red-200 text-sm"></span>@enderror
            </div>
            <!-- Upload images -->
            <div>
                <label for="images" class=" block text-gray-800 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Hoto (idan akwai)' : 'Images (optional) ' }}
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
                @error('images.*') <span class="text-red-500 bg-red-200 text-sm"></span>@enderror
            </div>
                <!-- submit button -->
                 <button type="submit" class="bg-blue-500 text-gray-200 flex items-center rounded border hover:bg-blue-700">
                    <i class="fas fa-paper-plane mr-2"></i>
                    {{ app()->getLocale() == 'ha' ? 'Qaddamar' : 'Submit' }}
                 </button>
         </form>
    </div>
</div>
