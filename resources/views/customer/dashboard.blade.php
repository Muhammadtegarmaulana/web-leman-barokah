<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                👋 Halo, {{ Auth::user()->name }}!
            </h2>
            <a href="{{ route('cart') }}" class="relative inline-flex items-center px-5 py-2.5 font-bold text-white transition-all duration-200 bg-indigo-600 rounded-full hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-1 focus:outline-none">
                🛒 Keranjang
                <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                    {{ count((array) session('cart')) }}
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm flex items-center">
                    <span class="text-green-500 mr-2">✅</span>
                    <p class="text-green-700 font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                    <p class="text-red-700 font-bold">{{ session('error') }}</p>
                </div>
            @endif

            <h3 class="text-xl font-bold text-gray-700 mb-6">Mau makan apa hari ini? 😋</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($menus as $menu)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden flex flex-col h-full border border-gray-100">
                    <div class="relative h-48 w-full overflow-hidden">
                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
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
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>