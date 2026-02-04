<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                🍽️ Menu Lezat Leman Barokah
            </h2>
            <a href="{{ route('cart') }}" class="relative inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition shadow-lg">
                🛒 Keranjang
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-bounce">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-10 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <form action="{{ route('customer.dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="relative flex-grow">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu favoritmu..." class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                    </div>

                    <div class="flex bg-gray-100 p-1 rounded-xl">
                        <button type="submit" name="category" value="semua" class="px-6 py-2 rounded-lg text-sm font-bold transition {{ request('category', 'semua') == 'semua' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Semua</button>
                        <button type="submit" name="category" value="makanan" class="px-6 py-2 rounded-lg text-sm font-bold transition {{ request('category') == 'makanan' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Makanan</button>
                        <button type="submit" name="category" value="minuman" class="px-6 py-2 rounded-lg text-sm font-bold transition {{ request('category') == 'minuman' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Minuman</button>
                    </div>

                    <button type="submit" class="bg-gray-800 text-white px-8 py-3 rounded-xl font-bold hover:bg-black transition">Cari</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($menus as $menu)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col h-full border border-gray-100">
                        <div class="relative h-48 w-full overflow-hidden">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-800 shadow-sm capitalize">
                                {{ $menu->category }}
                            </span>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $menu->name }}</h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-grow">{{ $menu->description }}</p>
                            <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-100">
                                <span class="text-indigo-600 font-extrabold text-lg">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                <a href="{{ route('add_to_cart', $menu->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-900 hover:bg-black text-white text-sm font-bold rounded-xl transition transform hover:-translate-y-1 shadow-md">
                                    + Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-gray-500 text-lg italic">Maaf, menu yang kamu cari tidak ditemukan... 🔍</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>