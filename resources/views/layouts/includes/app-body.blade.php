<div>
       <!-- Navbar -->
       <nav class="bg-gradient-to-r from-red-600 via-orange-600 to-yellow-400 p-2 my-2" x-data="{ open: false }">
           <div class="container mx-auto flex justify-between items-center">
               <a href="{{ route('dashboard') }}" class="text-xl font-bold text-white">{{ config('app.name', 'Sharkni') }}</a>
               <div class="flex items-center space-x-4">
                   @auth
                   <div class="relative">
                       @livewire('pages.notifications.notifications-list')
                   </div>
                   @endauth
                   <!-- زر القائمة الجانبية على الجوال -->
                   <button @click="open = !open" class="md:hidden focus:outline-none text-white">
                       <i class="fas fa-bars text-2xl"></i>
                    </button>
               </div>  
                
                <!-- القائمة -->
                <div :class="{ 'hidden': !open, 'flex': open }" class="hidden md:flex md:items-center md:space-x-4 flex-col md:flex-row absolute md:static top-16 left-0 w-full md:w-auto bg-blue-200 md:bg-transparent p-4 md:p-0 shadow-md md:shadow-none z-50">

            <a href="{{ route('tools.index') }}" 
               class="block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 font-bold text-xl {{ request()->routeIs('tools.index') ? ' underline p-2 rounded' : '' }}">
               {{ app()->getLocale() == 'ha' ? 'Kayan Aiki' : 'Tools' }}
            </a>

            <a href="{{ route('tools.add') }}" 
               class="block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 font-bold text-xl {{ request()->routeIs('tools.add') ? 'underline p-2 rounded' : '' }}">
               {{ app()->getLocale() == 'ha' ? 'qrar kayan Aiki' : 'Add Tool' }}
            </a>

            <a href="{{ route('rentals.index') }}" 
               class="block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 font-bold text-xl {{ request()->routeIs('rentals.index') ? 'underline p-2 rounded' : '' }}">
               {{ app()->getLocale() == 'ha' ? 'Neman Aro' : 'Rentals' }}
            </a>

            <a href="{{ route('damage.report') }}" 
               class="block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 font-bold text-xl {{ request()->routeIs('damage.report') ? 'underline p-2 rounded' : '' }}">
               {{ app()->getLocale() == 'ha' ? 'Rahoton Lalacewa' : 'Report Damage' }}
            </a>

            <a href="{{ route('categories.add') }}" 
               class="block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 font-bold text-xl {{ request()->routeIs('categories.add') ? 'underline p-2 rounded' : '' }}">
               {{ app()->getLocale() == 'ha' ? "Qara Nau'i" : 'Add Category' }}
            </a>

            <a href="{{ route('profile') }}" 
               class="block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 font-bold text-xl {{ request()->routeIs('profile') ? 'underline p-2 rounded' : '' }}">
               {{ app()->getLocale() == 'ha' ? 'Bayanan Mutun' : 'Profile' }}
            </a>

            <a href="{{ route('logout') }}" 
               class="block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 font-bold text-xl {{ request()->routeIs('logout') ? 'underline p-2 rounded' : '' }}">
               {{ app()->getLocale() == 'ha' ? 'Fita' : 'Logout' }}
            </a>


            <div class="mt-2 md:mt-0">
                @livewire('components.language-switcher')
            </div>
        </div>
    </div>
</nav>
<!-- End Navbar -->

            <!-- Page Content -->
            <main class="min-h-screen bg-gradient-to-r from-red-400 via-orange-300 to-yellow-200">
                
                {{ $slot }}
            </main>
            </div>