@php
    $isAdmin = auth('admin')->check();
    $logoutRoute = $isAdmin ? route('admin.logout') : route('logout');
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ $isAdmin ? route('admin.dashboard') : route('customer.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Dashboard Link -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link 
                        :href="$isAdmin ? route('admin.dashboard') : route('customer.dashboard')" 
                        :active="$isAdmin ? request()->routeIs('admin.dashboard') : request()->routeIs('customer.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                     @if($isAdmin)
        <x-nav-link 
            :href="route('admin.products.index')" 
            :active="request()->routeIs('admin.products.*')">
            {{ __('Product List') }}
        </x-nav-link>
    @endif
                </div>
            </div>

            <!-- Right -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">

                    <!-- Trigger -->
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                            <div>
                                {{ $isAdmin ? auth('admin')->user()->name : auth()->user()->name }}
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <!-- Content -->
                    <x-slot name="content">

                        {{-- Profile only for Customer --}}
                        @if(!$isAdmin)
                            <x-dropdown-link :href="route('customer.profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif

                        <!-- Logout -->
                        <form method="POST" action="{{ $logoutRoute }}">
                            @csrf
                            <x-dropdown-link :href="$logoutRoute"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>

                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">

        <!-- Links -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="$isAdmin ? route('admin.dashboard') : route('customer.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        

        <!-- User Info -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ $isAdmin ? auth('admin')->user()->name : auth()->user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                    {{ $isAdmin ? auth('admin')->user()->email : auth()->user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">

                {{-- Profile only for Customer --}}
                @if(!$isAdmin)
                    <x-responsive-nav-link :href="route('customer.profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Logout -->
                <form method="POST" action="{{ $logoutRoute }}">
                    @csrf
                    <x-responsive-nav-link :href="$logoutRoute"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

            </div>
        </div>
    </div>
</nav>
