<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div>
            @php
            $user = Auth()->user();
            app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
            session(['locale' => $user->language]); // تخزين اللغة في الجلسة
            @endphp
<!-- زر الإشعارات -->
<div x-data="{ open: false }"
     @click.away="open = false"
     wire:poll.60s="unreadCount"
     class="relative  scale-y-4 ">
    
    <!-- زر الجرس -->
    <button @click="open = !open"
        wire:click="toggleDropdown"
        class="relative p-2 bg-gray-100 text-black rounded-full hover:bg-gray-200 transition"
        title="الإشعارات">
        <i class="fas fa-bell text-xl"></i>
        @if (auth()->user()->unreadNotifications->count())
        <span class="absolute -top-1 -right-1 bg-red-500 text-red-50 text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
            {{ $unreadCount }}
        </span>     
        @endif
    </button>

    <!-- قائمة الإشعارات -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-4 w-80 bg-white shadow-lg rounded-md z-50"
         style="max-height: 400px; overflow-y: auto; "
         >
        <!-- رأس القائمة -->
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-bold text-gray-800 text-sm"><i class="fas fa-bell text-xl"></i> الإشعارات</h3>
            @if ($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-sm text-blue-600 hover:underline">
                    تعيين الكل كمقروء
                </button>
            @endif
            </div>

        <!-- محتوى الإشعارات -->
        <div class="p-0">
            
            @forelse (auth()->user()->unreadNotifications as $notification)
            <div wire:key="notification-{{ $notification->id }}"
                    class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer flex items-start">
                    
                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor">
                            <path d="M12 22s8-4 8-10V6a8 8 0 10-16 0v6c0 6 8 10 8 10z" />
                        </svg>
                    </div>

                    <div class="flex-1">
                     
                        <p class="text-gray-800 font-medium">{{ app()->getLocale() == 'ha' ? $notification->data['data']['message_ha'] : $notification->data['data']['message']  }}</p>
                        <div class="flex justify-between items-center mt-1">
                            <a href="#"
                               class="bg-blue-500 text-white px-4 py-2  rounded-lg transition duration-200 hover:bg-blue-900"
                               @click.stop>عرض</a>  
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500">لا توجد إشعارات غير مقروءة</div>
                    @endforelse
                    <a href="#" class="text-blue-500 hover:underline">عرض الإشعارات</a>
        </div>
    </div>
</div>
</div>
</div>
