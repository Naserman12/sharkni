<div class="container mx-auto py-10">
    {{-- In work, do what you enjoy. --}}
    <div class=" bg-blue-200 rounded-lg shadow-lg p-6">
        <!-- Title -->
         <h1 class=" text-3xl font-semibold mb-6 flex items-center" >
            <i class="fas fa-exclamation mr-2"></i>
            {{ app()->getLocale() == 'ha' ? 'Sarrafa Rahotannin Lalacewa' : 'Manage Damage Reports' }}
         </h1>

          <!-- Messages -->
        @if (session('message'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ $message }}
        </div>   
        @endif
        @error('form')
        <div class="mb-4 p-2 bg-red-100 text-red-700 rounded">
            {{ $message }}
        </div>   
        @enderror

        <!-- جدول التقارير -->
         <div class=" overflow-x-auto">
            <table class="min-w-full bg-blue-300 border rounded-lg">
                <thead>
                    <tr class="bg-gray-200 border-b">
                        <th class="py-2 px-4 text-left">{{ app()->getLocale() == 'ha' ? 'ID' : 'ID' }}</th>
                        <th class="py-2 px-4 text-left">{{ app()->getLocale() == 'ha' ? 'Neman Aro ID' : 'Borrow Report ID'}}</th>
                        <th class="py-2 px-4 text-left">{{ app()->getLocale() == 'ha' ? 'Bayanin Lalacewa' : 'Description'}}</th>
                        <th class="py-2 px-4 text-left">{{ app()->getLocale() == 'ha' ? 'Hotuna' : 'Images'}}</th>
                        <th class="py-2 px-4 text-left">{{ app()->getLocale() == 'ha' ? 'Mastayi' : 'Status'}}</th>
                        <th class="py-2 px-4 text-left">{{ app()->getLocale() == 'ha' ? 'Adadin Wararewa' : 'Resolution Amount'}}</th>
                        <th class="py-2 px-4 text-left">{{ app()->getLocale() == 'ha' ? 'Ranar Qirqira' : 'Created at'}}</th>
                        <th class="py-2 px-4 text-left">{{ app()->getLocale() == 'ha' ? 'Ayyuka' : 'Actions'}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report )
                        <tr>
                            <td class="py-2 px-4">{{$report->id}}</td>
                            <td class="py-2 px-4">{{$report->rental_id}}</td>
                            <td class="py-2 px-4">{{$report->description ?? (app()->getLocale() == 'ha' ? 'Babu Bayani' : 'No Description')}}</td>
                            <td class="py-2 px-4">
                                @if ($report->image_paths)
                                    <div class=" flex space-x-2">
                                        @foreach ($report->image_paths as $image)
                                            <a href="{{ asset('storage/' . $image)}}" target="_blank">
                                                <img src="{{ asset('storage/' . $image) }}" alt="Damage Image" class=" w-16 h-16 object-cover rounded">
                                            </a>
                                        @endforeach
                                    </div> 
                                @else
                                {{ app()->getLocale() == 'ha' ? 'Babu Hotina' : 'No Images'}}                               
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                @if ($editingReportId  === $report->id)
                                    <select wire:model="status" class="p-2 border rounded">
                                        <option value="pending">{{ app()->getLocale() == 'ha' ? 'Ana Jiran' : 'Pending' }}</option>
                                        <option value="pending">{{ app()->getLocale() == 'ha' ? 'An Karqa' : 'Accepted' }}</option>
                                        <option value="pending">{{ app()->getLocale() == 'ha' ? 'An qi' : 'Rejected' }}</option>
                                    </select>
                                    @error('status') <span class="text-red-600 bg-red-200">{{ $message }}</span> @enderror
                                    @else
                                    <span class="@if($report->status == 'accepted') text-green-600 bg-green-200  @elseif($report->status == 'rejected') text-red-600 bg-red-200 @else text-yellow-500 bg-yellow-100 @endif">
                                        {{ app()->getLocale() == 'ha' ? ($report->status == 'pending' ? 'Ana Jiran' : ($report->status == 'accepted' ? 'An Karaqa' : 'An qi' )) :  ucfirst($report->status)}}
                                    </span>
                                    @endif
                                </td>
                                <td class="py-2 px-4">
                                    @if ($editingReportId === $report->id)
                                    <input type="number" min="0" wire:model="resolution_amount"  class="p-2 border rounded w-32">
                                    @error('resolution_amount') <span class="text-red-600 bg-red-200">{{ $message }}</span> @enderror
                                @else
                                 {{ $report->resilution_amount ? '' . number_format($report->resolution_amount, 2) : (app()->getLocale() == 'ha' ? 'Babu Adadi' : 'Not Set') }}
                                @endif
                            </td>
                            <td class="py-2 px-4">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                            <td class="py-2 px-4">
                                @if ($editingReportId === $report->id)
                                    <button wire:click="updateReport" class=" bg-green-500 text-green-100 px-3 py-1 rounded hover:bg-green-600 mr-2">
                                        {{ app()->getLocale() == 'ha' ? 'Ajiya' : 'Save' }}
                                    </button>
                                    <button wire:click="cancelEdit" class=" bg-gray-500 text-gray-100 px-3 py-1 rounded hover:bg-gray-600 mr-2">
                                        {{ app()->getLocale() == 'ha' ? 'Soke' : 'Cancel' }}
                                    </button>
                                @else
                                    <button wire:click="editRepot({{ $report->id }})" class=" bg-blue-500 text-blue-100 px-3 py-1 rounded hover:bg-blue-600 mr-2">
                                        {{ app()->getLocale() == 'ha' ? 'Gyara' : 'Edit' }}
                                    </button>    
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                {{ app()->getLocale() == 'ha' ? 'Babu rehotannin lalacewa da aka samu.' : 'No damage reports found.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
         </div>
    </div>
</div>
