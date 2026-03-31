<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="block h-10 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="flex items-center gap-2">
                        <x-lucide-layout-dashboard class="w-4 h-4" /> {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" class="flex items-center gap-2">
                        <x-lucide-tags class="w-4 h-4" /> {{ __('Categories') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')" class="flex items-center gap-2">
                        <x-lucide-box class="w-4 h-4" /> {{ __('Products') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" class="flex items-center gap-2">
                        <x-lucide-shopping-cart class="w-4 h-4" /> {{ __('Orders') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown & Theme Toggle -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                
                <a href="{{ route('home') }}" class="relative text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 p-2 transition flex items-center bg-gray-50 dark:bg-gray-700 rounded-full" title="Kembali ke Toko">
                    <x-lucide-store class="w-5 h-5" />
                </a>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-100 focus:outline-none transition ease-in-out duration-150 shadow-sm border-gray-100 dark:border-gray-700">
                            <div>{{ Auth::user()->name }} (Admin)</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

                <!-- Theme Toggle -->
                <button @click="darkMode = !darkMode" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-lg text-sm p-2 transition border border-transparent dark:border-gray-700">
                    <x-lucide-moon class="w-5 h-5 hidden dark:block" />
                    <x-lucide-sun class="w-5 h-5 block dark:hidden" />
                </button>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden gap-2">
                <button @click="darkMode = !darkMode" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-lg text-sm p-2 transition">
                    <x-lucide-moon class="w-5 h-5 hidden dark:block" />
                    <x-lucide-sun class="w-5 h-5 block dark:hidden" />
                </button>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                <div class="flex items-center gap-2"><x-lucide-layout-dashboard class="w-4 h-4" /> {{ __('Dashboard') }}</div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                <div class="flex items-center gap-2"><x-lucide-tags class="w-4 h-4" /> {{ __('Categories') }}</div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                <div class="flex items-center gap-2"><x-lucide-box class="w-4 h-4" /> {{ __('Products') }}</div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                <div class="flex items-center gap-2"><x-lucide-shopping-cart class="w-4 h-4" /> {{ __('Orders') }}</div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('home')">
                <div class="flex items-center gap-2"><x-lucide-store class="w-4 h-4" /> {{ __('Kembali ke Toko') }}</div>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
