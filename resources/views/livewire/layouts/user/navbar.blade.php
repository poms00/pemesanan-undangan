<div x-data="{
    mobileMenuOpen: false,
    userDropdownOpen: false,
    currentRoute: 'dashboard'
}">

    <!-- Top Header with Logo and User Info -->
    <nav class="bg-white p-2 dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 px-4 py-2">
        <div class="max-w-9xl mx-auto px-4 sm:px-4 lg:px-4">
            <div class="flex justify-between items-center h-16">

                <!-- Logo Section -->
                <div class="flex items-center">
                    <a href="#" class="flex items-center space-x-3 group">
                        <div
                            class="h-10 w-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="white" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.001 3.001 0 01-3.75-.615A2.993 2.993 0 003 9.75c.896 0 1.7-.393 2.25-1.016A2.994 2.994 0 007.5 9.75c.896 0 1.7-.393 2.25-1.015A3.001 3.001 0 0113.5 9.349m3.75 9.75H18m0 0h3.64" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">MyApp</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('user.dashboard') }}" wire:navigate
                        class="tw-flex tw-items-center tw-rounded-lg tw-gap-1 tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-transition-all tw-duration-200 tw-group {{ request()->routeIs('user.dashboard') ? 'tw-text-blue-700 dark:tw-text-blue-300' : 'tw-text-gray-700 hover:tw-text-blue-700 dark:tw-text-gray-300 dark:hover:tw-text-blue-300' }} focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('user.template.user-template') }}" wire:navigate
                        class="tw-flex tw-items-center tw-rounded-lg tw-gap-1 tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-transition-all tw-duration-200 tw-group {{ request()->routeIs('user.template.user-template') ? 'tw-text-blue-700 dark:tw-text-blue-300' : 'tw-text-gray-700 hover:tw-text-blue-700 dark:tw-text-gray-300 dark:hover:tw-text-blue-300' }} focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <span>Template</span>
                    </a>

                    <div x-data="{ open: false }" class="relative inline-block text-left">
                        <!-- Trigger Button -->
                        <button @click="open = !open" @click.away="open = false"
                            class="tw-flex tw-items-center tw-gap-1 tw-px-4 tw-py-3 tw-rounded-lg tw-text-sm tw-font-medium tw-transition-all tw-duration-200 tw-group
                            {{ request()->routeIs('user.kategori.kategori') ? 'tw-text-blue-700 dark:tw-text-blue-300' : 'tw-text-gray-700 hover:tw-text-blue-700 dark:tw-text-gray-300 dark:hover:tw-text-blue-300' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                            </svg>
                            <span>Kategori</span>
                            <svg class="w-4 h-4 ml-1 transition-transform" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    
                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition
                            class="absolute top-8 left-0 z-50 mt-2 min-w-full w-max bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                    
                                @forelse ($kategoris as $kategori)
                                    <li>
                                        <a href="{{ route('user.kategori.kategori', $kategori->id) }}"
                                            class="block w-full px-4 py-2 whitespace-nowrap hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                                            {{ $kategori->nama_kategori }}
                                        </a>
                                    </li>
                                @empty
                                    <li>
                                        <span class="block w-full px-4 py-2 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                            Belum ada kategori
                                        </span>
                                    </li>
                                @endforelse
                    
                            </ul>
                        </div>
                    </div>
                    



                    <a href="#" wire:navigate
                        class="tw-flex tw-items-center tw-rounded-lg tw-gap-1 tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-transition-all tw-duration-200 tw-group {{ request()->routeIs('#') ? 'tw-text-blue-700 dark:tw-text-blue-300' : 'tw-text-gray-700 hover:tw-text-blue-700 dark:tw-text-gray-300 dark:hover:tw-text-blue-300' }} focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                        </svg>
                        <span>Tentang Kami</span>
                    </a>
                    <!-- Add more navigation items here -->
                </div>

                <!-- Right Section - User Dropdown & Mobile Menu -->
                <div class="flex items-center space-x-4">

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ userDropdownIsOpen: false }" x-on:keydown.esc.window="userDropdownIsOpen = false"
                        @click.outside="userDropdownIsOpen = false">

                        <!-- Profile Button -->
                        <button @click="userDropdownIsOpen = !userDropdownIsOpen"
                            class="flex items-center gap-2  rounded-lg text-gray-700 dark:text-gray-300 transition-all duration-200"
                            aria-haspopup="true" :aria-expanded="userDropdownIsOpen">

                            <!-- User Avatar -->
                            <div class="h-9 w-9 flex items-center justify-center rounded-full shrink-0 bg-gradient-to-br from-blue-500 to-purple-600"
                                aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="white" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                                </svg>
                            </div>

                            <!-- User Info - Hidden on Mobile -->
                            <div class="hidden sm:flex flex-col min-w-0 text-left">
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate text-left">
                                    {{ auth()->user()->name }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 truncate text-left">
                                    {{ auth()->user()->email }}
                                </span>
                            </div>

                            <!-- Dropdown Arrow -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="h-4 w-4 text-gray-400 transition-transform duration-200 hidden sm:block ml-auto"
                                :class="userDropdownIsOpen ? 'rotate-180' : ''" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-cloak x-show="userDropdownIsOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute mt-2 right-0 w-auto min-w-[180px] max-w-[460px] border divide-y divide-gray-100 bg-white dark:divide-gray-600 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-lg z-50 ring-1 ring-black ring-opacity-5"
                            role="menu">

                            <!-- User Info Header (Mobile Only) -->
                            <div class="px-4 py-3 sm:hidden border-b border-gray-100 dark:border-gray-600">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shrink-0">
                                        <span class="text-sm font-medium text-white">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                            {{ auth()->user()->name }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            {{ auth()->user()->email }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-1">
                                <a href="{{ route('profile') }}" wire:navigate
                                    class="flex items-center gap-3 px-4 py-2 text-sm font-medium transition-all duration-200 {{ request()->routeIs('profile') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 hover:text-blue-700 dark:text-gray-300 dark:hover:text-blue-300' }}  hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                    <span>{{ __('Profile') }}</span>
                                </a>

                                <a href="{{ route('user.pesanan.user-pesanan') }}" wire:navigate
                                    class="flex items-center gap-3 px-4 py-2 text-sm font-medium transition-all duration-200 {{ request()->routeIs('user.pesanan.user-pesanan') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 hover:text-blue-700 dark:text-gray-300 dark:hover:text-blue-300' }}  hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>

                                    <span>{{ __('Pesanan Saya') }}</span>
                                </a>

                            </div>

                            <!-- Logout Section -->
                            <div class="py-1">
                                <button wire:click="logout"
                                    class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300 focus:outline-none focus:bg-red-50 dark:focus:bg-red-900/20 text-left w-full transition-colors duration-150"
                                    role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="h-5 w-5 shrink-0" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M6 10a.75.75 0 0 1 .75-.75h9.546l-1.048-.943a.75.75 0 1 1 1.004-1.114l2.5 2.25a.75.75 0 0 1 0 1.114l-2.5 2.25a.75.75 0 1 1-1.004-1.114l1.048-.943H6.75A.75.75 0 0 1 6 10Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ __('Logout') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                        <span class="sr-only">Open main menu</span>
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="md:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <!-- Dashboard Link -->
                    <a href="#" @click="currentRoute = 'dashboard'; mobileMenuOpen = false"
                        :class="currentRoute === 'dashboard' ?
                            'bg-blue-50 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300' :
                            'text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white'"
                        class="flex items-center px-3 py-2 rounded-lg text-base font-medium transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                        Dashboard
                    </a>
                    <!-- Add more mobile navigation items here -->
                </div>
            </div>
        </div>
    </nav>
</div>
