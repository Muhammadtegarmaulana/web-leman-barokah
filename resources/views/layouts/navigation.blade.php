<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 transition transform hover:scale-105">
                        <div class="bg-indigo-600 text-white p-1.5 rounded-lg group-hover:bg-indigo-700 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-gray-800 group-hover:text-indigo-600 transition">
                            Leman<span class="text-indigo-600">Barokah</span>
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.menus.index')" :active="request()->routeIs('admin.menus.*')">
                            {{ __('Menu') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            {{ __('Pesanan') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'customer')
                        <x-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard')">
                            {{ __('Pesan Makan') }}
                        </x-nav-link>

                        <x-nav-link :href="route('cart')" :active="request()->routeIs('cart')">
                            <span class="flex items-center gap-1">
                                {{ __('Keranjang') }}
                                @if(session('cart') && count(session('cart')) > 0)
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full animate-bounce">
                                        {{ count(session('cart')) }}
                                    </span>
                                @endif
                            </span>
                        </x-nav-link>

                        <x-nav-link :href="route('customer.orders.index')" :active="request()->routeIs('customer.orders.*')">
                            {{ __('Riwayat') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-full text-gray-700 bg-gray-50 hover:bg-white hover:text-indigo-600 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            
                            <div class="flex flex-col items-end mr-2 text-right">
                                <span class="font-bold">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] uppercase font-bold tracking-wider {{ Auth::user()->role === 'admin' ? 'text-indigo-500' : 'text-green-500' }}">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>

                            <div class="p-1 bg-gray-200 rounded-full">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                            <p class="text-xs text-gray-500">Login sebagai:</p>
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ __('Pengaturan Akun') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="text-red-600 hover:bg-red-50 flex items-center gap-2"
                                    onclick="event.preventDefault(); 
                                        Swal.fire({
                                            title: 'Ingin keluar?',
                                            text: 'Sesi anda akan diakhiri.',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Ya, Logout',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                this.closest('form').submit();
                                            }
                                        });">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                {{ __('Keluar Aplikasi') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100 shadow-inner">
        <div class="pt-2 pb-3 space-y-1 px-2">
            
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="rounded-lg">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.menus.index')" :active="request()->routeIs('admin.menus.*')" class="rounded-lg">
                    {{ __('Daftar Menu') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" class="rounded-lg">
                    {{ __('Pesanan Masuk') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')" class="rounded-lg">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'customer')
                <x-responsive-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard')" class="rounded-lg">
                    {{ __('Pesan Makan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cart')" :active="request()->routeIs('cart')" class="rounded-lg">
                    {{ __('Keranjang') }}
                    @if(session('cart'))
                        <span class="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ count(session('cart')) }}</span>
                    @endif
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customer.orders.index')" :active="request()->routeIs('customer.orders.*')" class="rounded-lg">
                    {{ __('Riwayat') }}
                </x-responsive-nav-link>
            @endif

        </div>

        <div class="pt-4 pb-4 border-t border-gray-200 bg-gray-50">
            <div class="px-4 flex items-center gap-3">
                <div class="bg-indigo-100 p-2 rounded-full text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-lg">
                    {{ __('Pengaturan Akun') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="text-red-600 hover:bg-red-50 rounded-lg"
                            onclick="event.preventDefault(); 
                                Swal.fire({
                                    title: 'Ingin keluar?',
                                    text: 'Sesi anda akan diakhiri.',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, Logout',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        this.closest('form').submit();
                                    }
                                });">
                        {{ __('Keluar Aplikasi') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>