<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="">
                        <img src="../../../icon.png" alt="icon" style="height: 48px; width: 55px;">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(Auth::user()->usertype === 'admin')
                            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                                {{ __('Products') }}
                            </x-nav-link>
                            <x-nav-link :href="route('transactions.view')" :active="request()->routeIs('transactions.view')">
                                {{ __('Transactions') }}
                            </x-nav-link>
                            <x-nav-link :href="route('analytics.view')" :active="request()->routeIs('analytics.view')">
                                {{ __('Analytics') }}
                            </x-nav-link>
                            <x-nav-link :href="route('promotion.index')" :active="request()->routeIs('promotion.index')">
                                {{ __('Promotion') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('transaction.view')" :active="request()->routeIs('transaction.view')">
                                {{ __('Transaction') }}
                            </x-nav-link>
                            <x-nav-link :href="route('help.view')" :active="request()->routeIs('help.view')">
                                {{ __('Help') }}
                            </x-nav-link>
                            <x-nav-link :href="route('promo.view')" :active="request()->routeIs('promo.view')">
                                {{ __('Promo') }}
                            </x-nav-link>
                        @endif
                    @else
                        <x-nav-link :href="route('guest.dashboard')" :active="request()->routeIs('guest.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('help.view')" :active="request()->routeIs('help.view')">
                            {{ __('Help') }}
                        </x-nav-link>
                        <x-nav-link :href="route('promo.view')" :active="request()->routeIs('promo.view')">
                            {{ __('Promo') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown or Login -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    @if(Auth::user()->usertype !== 'admin')
                        <div class="relative me-3">
                            <a href="{{ route('cart.view') }}" class="relative p-2 text-gray-600 dark:text-gray-300 block" aria-label="Shopping Cart">
                                <i class="fas fa-shopping-cart text-2xl"></i>
                                @if(isset($cartItemCount) && $cartItemCount > 0)
                                    <span class="absolute -top-0 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ $cartItemCount }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    @endif
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
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
                @else
                    <x-nav-link :href="route('login')" class="text-gray-600 dark:text-gray-300">
                        {{ __('Login') }}
                    </x-nav-link>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
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
            @auth
                @if(Auth::user()->usertype === 'admin')
                    <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                        {{ __('Products') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('transactions.view')" :active="request()->routeIs('transactions.view')">
                        {{ __('Transactions') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('analytics.view')" :active="request()->routeIs('analytics.view')">
                        {{ __('Analytics') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('promotion.index')" :active="request()->routeIs('promotion.index')">
                        {{ __('Promotion') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('transaction.view')" :active="request()->routeIs('transaction.view')">
                        {{ __('Transaction') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('help.view')" :active="request()->routeIs('help.view')">
                        {{ __('Help') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('promo.view')" :active="request()->routeIs('promo.view')">
                        {{ __('Promo') }}
                    </x-responsive-nav-link>
                @endif
            @else
                <x-responsive-nav-link :href="route('guest.dashboard')" :active="request()->routeIs('guest.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('help.view')" :active="request()->routeIs('help.view')">
                    {{ __('Help') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('promo.view')" :active="request()->routeIs('promo.view')">
                    {{ __('Promo') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
            @endauth
        </div>
    </div>
</nav>
