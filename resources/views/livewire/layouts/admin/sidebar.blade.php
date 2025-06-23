<div x-data="{
    sidebarIsOpen: false,
    sidebarCollapsed: false,
    isDesktop: window.innerWidth >= 768,
    isInitialized: false
}" x-init="// Prevent transitions on initial load
setTimeout(() => {
    isInitialized = true;
}, 100);

const handleResize = () => {
    const wasDesktop = isDesktop;
    isDesktop = window.innerWidth >= 768;

    if (isDesktop && !wasDesktop) {
        sidebarIsOpen = false;
    }
};

window.addEventListener('resize', handleResize);

$el._x_cleanup = () => {
    window.removeEventListener('resize', handleResize);
};" class="tw-flex tw-min-h-screen">

    <!-- Header -->
    <header
        class="tw-fixed tw-top-0 tw-right-0 tw-z-40 tw-bg-white tw-border-b tw-border-gray-200 dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-h-16"
        x-bind:class="{
            'tw-left-0': !isDesktop || sidebarIsOpen,
            'tw-left-64': !sidebarCollapsed && isDesktop && !sidebarIsOpen,
            'tw-left-20': sidebarCollapsed && isDesktop && !sidebarIsOpen,
            'tw-transition-all tw-duration-300 tw-ease-in-out': isInitialized
        }">
        <div class="tw-flex tw-items-center tw-justify-between tw-px-4 tw-py-3 tw-h-full">
            <!-- Mobile Menu Button -->
            <button type="button" x-on:click="sidebarIsOpen = !sidebarIsOpen"
                class="tw-inline-flex tw-items-center tw-justify-center tw-p-2 tw-rounded-md tw-text-gray-500 hover:tw-text-gray-900 hover:tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-inset focus:tw-ring-blue-500 md:tw-hidden dark:tw-text-gray-400 dark:hover:tw-text-gray-100 dark:hover:tw-bg-gray-700 tw-transition-colors tw-duration-150"
                aria-expanded="false">
                <span class="tw-sr-only">Open main menu</span>
                <!-- Menu icon when sidebar is closed -->
                <svg x-show="!sidebarIsOpen" class="tw-block tw-h-6 tw-w-6" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <!-- X icon when sidebar is open -->
                <svg x-show="sidebarIsOpen" class="tw-block tw-h-6 tw-w-6" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Desktop Sidebar Toggle -->
            <button type="button" x-on:click="sidebarCollapsed = !sidebarCollapsed"
                class="tw-hidden md:tw-inline-flex tw-items-center tw-justify-center tw-w-10 tw-h-10 tw-rounded-full tw-border tw-border-gray-300 tw-bg-white tw-text-gray-600 
                hover:tw-text-blue-600 hover:tw-border-blue-500 hover:tw-shadow-sm
                active:tw-scale-95 active:tw-bg-gray-100 dark:active:tw-bg-gray-700
                tw-transition-all tw-duration-150
                focus:tw-outline-none 
                dark:tw-border-gray-600 dark:tw-bg-gray-800 dark:tw-text-gray-300"
                :aria-expanded="false">
                <span class="tw-sr-only">Toggle sidebar</span>
                <svg class="tw-h-5 tw-w-5 tw-transition-transform tw-duration-300"
                    x-bind:class="sidebarCollapsed ? 'tw-rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8M4 18h16" />
                </svg>
            </button>

            <!-- User Profile Section -->
            <div x-data="{ userDropdownIsOpen: false }" class="tw-relative tw-ml-4"
                x-on:keydown.esc.window="userDropdownIsOpen = false">

                <!-- Profile Button -->
                <button @click="userDropdownIsOpen = !userDropdownIsOpen"
                    class="tw-flex tw-items-center tw-gap-3 tw-p-2 tw-rounded-lg tw-text-gray-700 dark:tw-text-gray-300 tw-w-full tw-text-left tw-transition-colors tw-duration-150"
                    aria-haspopup="true" :aria-expanded="userDropdownIsOpen">
                    <!-- Icon User -->
                    <div class="tw-h-9 tw-w-9 tw-flex tw-items-center tw-justify-center tw-rounded-full tw-shrink-0 tw-bg-gradient-to-br tw-from-blue-500 tw-to-purple-600"
                        aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="white" class="tw-w-6 tw-h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                        </svg>
                    </div>

                    <!-- User Info -->
                    <div class="tw-hidden sm:tw-flex tw-flex-col tw-min-w-0">
                        <span class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-gray-100 tw-truncate">
                            {{ auth()->user()->name }}
                        </span>
                        <span class="tw-text-xs tw-text-gray-500 dark:tw-text-gray-400 tw-truncate">
                            {{ auth()->user()->email }}
                        </span>
                    </div>

                    <!-- Dropdown Arrow -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="tw-h-4 tw-w-4 tw-text-gray-400 tw-transition-transform tw-duration-200 tw-hidden sm:tw-block tw-ml-auto"
                        :class="userDropdownIsOpen ? 'tw-rotate-180' : ''" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-cloak x-show="userDropdownIsOpen" @click.outside="userDropdownIsOpen = false"
                    x-transition:enter="tw-transition tw-ease-out tw-duration-100"
                    x-transition:enter-start="tw-transform tw-opacity-0 tw-scale-95"
                    x-transition:enter-end="tw-transform tw-opacity-100 tw-scale-100"
                    x-transition:leave="tw-transition tw-ease-in tw-duration-75"
                    x-transition:leave-start="tw-transform tw-opacity-100 tw-scale-100"
                    x-transition:leave-end="tw-transform tw-opacity-0 tw-scale-95"
                    class="tw-absolute tw-mt-2 tw-right-0 tw-w-auto tw-min-w-[200px] tw-max-w-[320px] tw-border tw-divide-y tw-divide-gray-100 tw-bg-white 
             dark:tw-divide-gray-600 dark:tw-border-gray-600 dark:tw-bg-gray-700 
             tw-rounded-lg tw-shadow-lg tw-z-50 tw-ring-1 tw-ring-black tw-ring-opacity-5"
                    role="menu">

                    <!-- User Info Header (Mobile) -->
                    <div class="tw-px-4 tw-py-3 sm:tw-hidden tw-border-b tw-border-gray-100 dark:tw-border-gray-600">
                        <div class="tw-flex tw-items-center tw-gap-3">
                            <div
                                class="tw-h-10 tw-w-10 tw-bg-gradient-to-br tw-from-blue-500 tw-to-purple-600 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                <span class="tw-text-sm tw-font-medium tw-text-white">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                            </div>
                            <div class="tw-flex tw-flex-col tw-min-w-0">
                                <span
                                    class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-gray-100 tw-truncate">
                                    {{ auth()->user()->name }}
                                </span>
                                <span class="tw-text-xs tw-text-gray-500 dark:tw-text-gray-400 tw-truncate">
                                    {{ auth()->user()->email }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Items -->
                    <div class="tw-py-1">
                        <a href="{{ route('profile') }}" wire:navigate
                            class="tw-flex tw-items-center tw-gap-3 tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-700 
                     hover:tw-bg-gray-100 hover:tw-text-gray-900 
                     dark:tw-text-gray-300 dark:hover:tw-bg-gray-600 dark:hover:tw-text-gray-100 
                     focus:tw-outline-none focus:tw-bg-gray-100 dark:focus:tw-bg-gray-600 
                     tw-transition-colors tw-duration-150"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="tw-h-4 tw-w-4 tw-shrink-0" aria-hidden="true">
                                <path
                                    d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                            </svg>
                            <span>{{ __('Profile') }}</span>
                        </a>

                        <a href="#"
                            class="tw-flex tw-items-center tw-gap-3 tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-700 
                     hover:tw-bg-gray-100 hover:tw-text-gray-900 
                     dark:tw-text-gray-300 dark:hover:tw-bg-gray-600 dark:hover:tw-text-gray-100 
                     focus:tw-outline-none focus:tw-bg-gray-100 dark:focus:tw-bg-gray-600 
                     tw-transition-colors tw-duration-150"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="tw-h-4 tw-w-4 tw-shrink-0" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M7.84 1.804A1 1 0 0 1 8.82 1h2.36a1 1 0 0 1 .98.804l.331 1.652a6.993 6.993 0 0 1 1.929 1.115l1.598-.54a1 1 0 0 1 1.186.447l1.18 2.044a1 1 0 0 1-.205 1.251l-1.267 1.113a7.047 7.047 0 0 1 0 2.228l1.267 1.113a1 1 0 0 1 .206 1.25l-1.18 2.045a1 1 0 0 1-1.187.447l-1.598-.54a6.993 6.993 0 0 1-1.929 1.115l-.33 1.652a1 1 0 0 1-.98.804H8.82a1 1 0 0 1-.98-.804l-.331-1.652a6.993 6.993 0 0 1-1.929-1.115l-1.598.54a1 1 0 0 1-1.186-.447l-1.18-2.044a1 1 0 0 1 .205-1.251l1.267-1.114a7.05 7.05 0 0 1 0-2.227L1.821 7.773a1 1 0 0 1-.206-1.25l1.18-2.045a1 1 0 0 1 1.187-.447l1.598.54A6.992 6.992 0 0 1 7.51 3.456l.33-1.652ZM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('Settings') }}</span>
                        </a>
                    </div>

                    <!-- Logout Section -->
                    <div class="tw-py-1">
                        <button wire:click="logout"
                            class="tw-flex tw-items-center tw-gap-3 tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-red-600 
                     hover:tw-bg-red-50 hover:tw-text-red-700 
                     dark:tw-text-red-400 dark:hover:tw-bg-red-900/20 dark:hover:tw-text-red-300 
                     focus:tw-outline-none focus:tw-bg-red-50 dark:focus:tw-bg-red-900/20 
                     tw-text-left tw-w-full tw-transition-colors tw-duration-150"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="tw-h-4 tw-w-4 tw-shrink-0" aria-hidden="true">
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
        </div>
    </header>

    <!-- Sidebar -->
    <nav class="tw-fixed tw-left-0 tw-z-30 tw-flex tw-h-screen tw-shrink-0 tw-flex-col tw-border-r tw-border-gray-200 tw-bg-white dark:tw-border-gray-700 dark:tw-bg-gray-800"
        x-bind:class="{
            'tw-w-64 tw-translate-x-0': (sidebarIsOpen && !isDesktop) || (!sidebarCollapsed && isDesktop),
            'tw-w-20': sidebarCollapsed && isDesktop,
            '-tw-translate-x-full tw-w-64': !sidebarIsOpen && !isDesktop,
            'tw-transition-all tw-duration-300 tw-ease-in-out': isInitialized
        }"
        aria-label="sidebar navigation">

        <!-- Logo -->
        <div
            class="tw-flex tw-items-center tw-justify-between tw-p-4 tw-border-b tw-border-gray-200 dark:tw-border-gray-700 tw-min-h-[4.8rem]">
            <a href="{{ route('admin.dashboard') }}" wire:navigate
                class="tw-flex tw-items-center tw-text-2xl tw-font-bold tw-text-gray-800 dark:tw-text-gray-200"
                x-bind:class="{
                    'tw-justify-center': (sidebarCollapsed && isDesktop),
                    'tw-transition-all tw-duration-300 tw-ease-in-out': isInitialized
                }">
                <span class="tw-sr-only">Homepage</span>
                <x-application-logo
                    class="tw-h-10 tw-w-auto tw-block tw-fill-current tw-text-gray-800 dark:tw-text-gray-200" />
                <span x-show="!(sidebarCollapsed && isDesktop)"
                    x-bind:class="isInitialized ? 'tw-transition-all tw-ease-in-out tw-duration-300 tw-delay-100' : ''"
                    x-transition:enter="tw-transition-all tw-ease-in-out tw-duration-300 tw-delay-100"
                    x-transition:enter-start="tw-opacity-0 tw-translate-x-2"
                    x-transition:enter-end="tw-opacity-100 tw-translate-x-0"
                    x-transition:leave="tw-transition-all tw-ease-in-out tw-duration-200"
                    x-transition:leave-start="tw-opacity-100 tw-translate-x-0"
                    x-transition:leave-end="tw-opacity-0 tw-translate-x-2" class="tw-ml-2">MyApp</span>
            </a>

            <!-- Close button for mobile -->
            <button type="button" x-on:click="sidebarIsOpen = false"
                class="tw-inline-flex tw-items-center tw-justify-center tw-p-1 tw-rounded-md tw-text-gray-500 hover:tw-text-gray-900 hover:tw-bg-gray-100 md:tw-hidden dark:tw-text-gray-400 dark:hover:tw-text-gray-100 dark:hover:tw-bg-gray-700 tw-transition-colors tw-duration-200">
                <span class="tw-sr-only">Close sidebar</span>
                <svg class="tw-h-5 tw-w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Links -->
        <div class="tw-flex tw-flex-col tw-gap-2 tw-p-3">

            <!-- Dashboard Link -->
            <div x-data="{ tooltip: false }" class="tw-relative">
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    class="tw-flex tw-items-center tw-rounded-lg tw-gap-3 tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-transition-all tw-duration-200 tw-group {{ request()->routeIs('admin.dashboard') ? 'tw-bg-blue-50 tw-text-blue-700 dark:tw-bg-blue-900 dark:tw-text-blue-300' : 'tw-text-gray-700 hover:tw-bg-gray-100 hover:tw-text-gray-900 dark:tw-text-gray-300 dark:hover:tw-bg-gray-700 dark:hover:tw-text-gray-100' }} focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-ring-offset-2"
                    x-on:mouseenter="tooltip = (sidebarCollapsed && isDesktop)" x-on:mouseleave="tooltip = false">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="tw-size-6 tw-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    <span x-show="!(sidebarCollapsed && isDesktop)"
                        x-bind:class="isInitialized ? 'tw-transition-all tw-ease-in-out tw-duration-300 tw-delay-100' : ''"
                        x-transition:enter="tw-transition-all tw-ease-in-out tw-duration-300 tw-delay-100"
                        x-transition:enter-start="tw-opacity-0 tw-translate-x-2"
                        x-transition:enter-end="tw-opacity-100 tw-translate-x-0"
                        x-transition:leave="tw-transition-all tw-ease-in-out tw-duration-200"
                        x-transition:leave-start="tw-opacity-100 tw-translate-x-0"
                        x-transition:leave-end="tw-opacity-0 tw-translate-x-2"
                        class="tw-whitespace-nowrap tw-text-base tw-font-semibold tw-tracking-tight tw-text-gray-800 dark:tw-text-gray-200">
                        {{ __('Dashboard') }}
                    </span>
                </a>

                <!-- Tooltip for collapsed state -->
                <div x-show="tooltip" x-cloak
                    class="tw-absolute tw-left-full tw-ml-2 tw-top-1/2 tw-transform -tw-translate-y-1/2 tw-bg-gray-900 tw-text-white tw-text-sm tw-px-2 tw-py-1 tw-rounded tw-shadow-lg tw-whitespace-nowrap tw-z-50"
                    x-transition:enter="tw-transition tw-ease-out tw-duration-200"
                    x-transition:enter-start="tw-opacity-0 tw-scale-95"
                    x-transition:enter-end="tw-opacity-100 tw-scale-100"
                    x-transition:leave="tw-transition tw-ease-in tw-duration-150"
                    x-transition:leave-start="tw-opacity-100 tw-scale-100"
                    x-transition:leave-end="tw-opacity-0 tw-scale-95">
                    {{ __('Dashboard') }}
                    <div
                        class="tw-absolute tw-right-full tw-top-1/2 tw-transform -tw-translate-y-1/2 tw-border-4 tw-border-transparent tw-border-r-gray-900">
                    </div>
                </div>
            </div>

            <!--users link-->
            <div x-data="{ tooltip: false }" class="tw-relative">
                <a href="{{ route('admin.users.user-table') }}" wire:navigate
                    class="tw-flex tw-items-center tw-rounded-lg tw-gap-3 tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-transition-all tw-duration-200 tw-group {{ request()->routeIs('admin.users.user-table') ? 'tw-bg-blue-50 tw-text-blue-700 dark:tw-bg-blue-900 dark:tw-text-blue-300' : 'tw-text-gray-700 hover:tw-bg-gray-100 hover:tw-text-gray-900 dark:tw-text-gray-300 dark:hover:tw-bg-gray-700 dark:hover:tw-text-gray-100' }} focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-ring-offset-2"
                    x-on:mouseenter="tooltip = (sidebarCollapsed && isDesktop)" x-on:mouseleave="tooltip = false">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="tw-size-6 tw-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span x-show="!(sidebarCollapsed && isDesktop)"
                        x-bind:class="isInitialized ? 'tw-transition-all tw-ease-in-out tw-duration-300 tw-delay-100' : ''"
                        x-transition:enter="tw-transition-all tw-ease-in-out tw-duration-300 tw-delay-100"
                        x-transition:enter-start="tw-opacity-0 tw-translate-x-2"
                        x-transition:enter-end="tw-opacity-100 tw-translate-x-0"
                        x-transition:leave="tw-transition-all tw-ease-in-out tw-duration-200"
                        x-transition:leave-start="tw-opacity-100 tw-translate-x-0"
                        x-transition:leave-end="tw-opacity-0 tw-translate-x-2"
                        class="tw-whitespace-nowrap tw-text-base tw-font-semibold tw-tracking-tight tw-text-gray-800 dark:tw-text-gray-200">
                        {{ __('Users Manage') }}
                    </span>
                </a>

                <!-- Tooltip for collapsed state -->
                <div x-show="tooltip" x-cloak
                    class="tw-absolute tw-left-full tw-ml-2 tw-top-1/2 tw-transform -tw-translate-y-1/2 tw-bg-gray-900 tw-text-white tw-text-sm tw-px-2 tw-py-1 tw-rounded tw-shadow-lg tw-whitespace-nowrap tw-z-50"
                    x-transition:enter="tw-transition tw-ease-out tw-duration-200"
                    x-transition:enter-start="tw-opacity-0 tw-scale-95"
                    x-transition:enter-end="tw-opacity-100 tw-scale-100"
                    x-transition:leave="tw-transition tw-ease-in tw-duration-150"
                    x-transition:leave-start="tw-opacity-100 tw-scale-100"
                    x-transition:leave-end="tw-opacity-0 tw-scale-95">
                    {{ __('Users Manage') }}
                    <div
                        class="tw-absolute tw-right-full tw-top-1/2 tw-transform -tw-translate-y-1/2 tw-border-4 tw-border-transparent tw-border-r-gray-900">
                    </div>
                </div>
            </div>
            <!--produks link-->
            <div x-data="{ tooltip: false }" class="tw-relative">
                @php
                $isActive = $activeMenu === 'produks';
            @endphp
            
                <a href="{{ route('admin.produks.produks-table') }}"
                    wire:navigate
                    class="tw-flex tw-items-center tw-rounded-lg tw-gap-3 tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-transition-all tw-duration-200 tw-group
                        {{ $isActive ? 'tw-bg-blue-50 tw-text-blue-700 dark:tw-bg-blue-900 dark:tw-text-blue-300' : 'tw-text-gray-700 hover:tw-bg-gray-100 hover:tw-text-gray-900 dark:tw-text-gray-300 dark:hover:tw-bg-gray-700 dark:hover:tw-text-gray-100' }}
                        focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-ring-offset-2"
                    x-on:mouseenter="tooltip = (sidebarCollapsed && isDesktop)" 
                    x-on:mouseleave="tooltip = false">
            
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="tw-size-6 tw-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
            
                    <span x-show="!(sidebarCollapsed && isDesktop)"
                        x-bind:class="isInitialized ? 'tw-transition-all tw-ease-in-out tw-duration-300 tw-delay-100' : ''"
                        x-transition:enter="tw-transition-all tw-ease-in-out tw-duration-300 tw-delay-100"
                        x-transition:enter-start="tw-opacity-0 tw-translate-x-2"
                        x-transition:enter-end="tw-opacity-100 tw-translate-x-0"
                        x-transition:leave="tw-transition-all tw-ease-in-out tw-duration-200"
                        x-transition:leave-start="tw-opacity-100 tw-translate-x-0"
                        x-transition:leave-end="tw-opacity-0 tw-translate-x-2"
                        class="tw-whitespace-nowrap tw-text-base tw-font-semibold tw-tracking-tight tw-text-gray-800 dark:tw-text-gray-200">
                        {{ __('product') }}
                    </span>
                </a>
            
            

                <!-- Tooltip for collapsed state -->
                <div x-show="tooltip" x-cloak
                    class="tw-absolute tw-left-full tw-ml-2 tw-top-1/2 tw-transform -tw-translate-y-1/2 tw-bg-gray-900 tw-text-white tw-text-sm tw-px-2 tw-py-1 tw-rounded tw-shadow-lg tw-whitespace-nowrap tw-z-50"
                    x-transition:enter="tw-transition tw-ease-out tw-duration-200"
                    x-transition:enter-start="tw-opacity-0 tw-scale-95"
                    x-transition:enter-end="tw-opacity-100 tw-scale-100"
                    x-transition:leave="tw-transition tw-ease-in tw-duration-150"
                    x-transition:leave-start="tw-opacity-100 tw-scale-100"
                    x-transition:leave-end="tw-opacity-0 tw-scale-95">
                    {{ __('product') }}
                    <div
                        class="tw-absolute tw-right-full tw-top-1/2 tw-transform -tw-translate-y-1/2 tw-border-4 tw-border-transparent tw-border-r-gray-900">
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="tw-flex-1 tw-pt-16"
        x-bind:class="{
            'tw-ml-64': !sidebarCollapsed && isDesktop,
            'tw-ml-20': sidebarCollapsed && isDesktop,
            'tw-ml-0': !isDesktop,
            'tw-transition-all tw-duration-300 tw-ease-in-out': isInitialized
        }">

    </main>

    <!-- Mobile Overlay -->
    <div x-show="sidebarIsOpen && !isDesktop"
        x-transition:enter="tw-transition-opacity tw-ease-linear tw-duration-300"
        x-transition:enter-start="tw-opacity-0" x-transition:enter-end="tw-opacity-100"
        x-transition:leave="tw-transition-opacity tw-ease-linear tw-duration-300"
        x-transition:leave-start="tw-opacity-100" x-transition:leave-end="tw-opacity-0"
        class="tw-fixed tw-inset-0 tw-z-20 tw-bg-black tw-bg-opacity-50 md:tw-hidden"
        x-on:click="sidebarIsOpen = false" aria-hidden="true">
    </div>

</div>
