<nav class="bg-gradient-to-r from-red-600 via-orange-600 to-yellow-500 shadow-lg" x-data="{ open: false }">

    <div class="container mx-auto flex justify-between items-center px-4 py-3">

        <!-- Logo -->
        <a href="{{ route('dashboard') }}"
           class="text-xl font-bold text-white tracking-wide hover:opacity-90 transition">
            {{ config('app.name', 'Sharkni') }}
        </a>

        <!-- Right section -->
        <div class="flex items-center gap-4">

            @auth
                @livewire('pages.notifications.notifications-list')
            @endauth

            <!-- Mobile button -->
            <button @click="open = !open"
                class="md:hidden text-white focus:outline-none hover:scale-105 transition">
                <i class="fas fa-bars text-2xl"></i>
            </button>

        </div>
    </div>

    <!-- Menu -->
    <div
        :class="open ? 'block' : 'hidden'"
        class="md:flex md:items-center md:justify-center md:gap-6 bg-orange-500/10 md:bg-transparent px-4 md:px-0 pb-4 md:pb-0"
    >

        <!-- Home -->
        <a href="{{ route('home') }}"
           class="block md:inline-block text-white font-medium py-2 md:py-0 hover:text-yellow-200 transition
           {{ request()->routeIs('home') ? 'text-yellow-200 underline' : '' }}">
            {{ app()->getLocale() == 'ha' ? 'Gida' : 'Home' }}
        </a>

        <!-- Tools -->
        <a href="{{ route('tools.index') }}"
           class="block md:inline-block text-white font-medium py-2 md:py-0 hover:text-yellow-200 transition
           {{ request()->routeIs('tools.index') ? 'text-yellow-200 underline' : '' }}">
            {{ app()->getLocale() == 'ha' ? 'Kayan Aiki' : 'Tools' }}
        </a>

        <!-- Add Tool -->
        <a href="{{ route('tools.add') }}"
           class="block md:inline-block text-white font-medium py-2 md:py-0 hover:text-yellow-200 transition
           {{ request()->routeIs('tools.add') ? 'text-yellow-200 underline' : '' }}">
            {{ app()->getLocale() == 'ha' ? 'Ƙara Kayan Aiki' : 'Add Tool' }}
        </a>

        <!-- Rentals -->
        <a href="{{ route('rentals.index') }}"
           class="block md:inline-block text-white font-medium py-2 md:py-0 hover:text-yellow-200 transition
           {{ request()->routeIs('rentals.index') ? 'text-yellow-200 underline' : '' }}">
            {{ app()->getLocale() == 'ha' ? 'Neman Aro' : 'Rentals' }}
        </a>

        <!-- Profile -->
        <a href="{{ route('profile') }}"
           class="block md:inline-block text-white font-medium py-2 md:py-0 hover:text-yellow-200 transition
           {{ request()->routeIs('profile') ? 'text-yellow-200 underline' : '' }}">
            {{ app()->getLocale() == 'ha' ? 'Bayanan Mutum' : 'Profile' }}
        </a>

        <!-- Logout -->
        @auth
        <a href="{{ route('logout') }}"
           class="block md:inline-block text-white font-medium py-2 md:py-0 hover:text-red-200 transition">
            {{ app()->getLocale() == 'ha' ? 'Fita' : 'Logout' }}
        </a>
        @endauth

        <!-- Language Switcher -->
        <div class="mt-3 md:mt-0 md:ml-4">
            @livewire('components.language-switcher')
        </div>

    </div>
</nav>