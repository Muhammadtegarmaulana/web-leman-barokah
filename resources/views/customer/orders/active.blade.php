<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            ⏳ Pesanan Sedang Berjalan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @forelse($orders as $order)
                <div class="mb-8 bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 pb-6 mb-6 gap-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">ID Pesanan: #{{ $order->id }}</p>
                            <h3 class="text-lg font-black text-gray-800 uppercase italic">
                                {{ $order->order_type == 'dine_in' ? '🍽️ Makan di Tempat (Meja '.$order->table_number.')' : '🛍️ Bungkus / Pickup' }}
                            </h3>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            @if($order->queue_number)
                                <div class="bg-indigo-600 text-white px-6 py-2 rounded-2xl shadow-lg shadow-indigo-200 text-center">
                                    <p class="text-[10px] uppercase font-bold opacity-80">Antrian</p>
                                    <p class="text-2xl font-black leading-none">{{ $order->queue_number }}</p>
                                </div>
                            @endif

                            <div class="text-right">
                                @php
                                    $statusLabels = [
                                        'pending' => ['text' => 'Menunggu Konfirmasi', 'color' => 'bg-gray-100 text-gray-600', 'desc' => 'Admin sedang mengecek pesananmu.'],
                                        'processing' => ['text' => 'Sedang Dimasak', 'color' => 'bg-blue-100 text-blue-600 animate-pulse', 'desc' => 'Koki kami sedang menyiapkan hidanganmu.'],
                                        'ready' => ['text' => 'Siap Diambil', 'color' => 'bg-green-100 text-green-700', 'desc' => 'Pesananmu sudah siap! Silakan ambil di kasir.'],
                                    ];
                                    $current = $statusLabels[$order->order_status] ?? $statusLabels['pending'];
                                @endphp
                                <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-tighter {{ $current['color'] }} border border-opacity-10">
                                    {{ $current['text'] }}
                                </span>
                                <p class="text-[10px] text-gray-400 mt-2 italic">{{ $current['desc'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <p class="font-bold text-sm text-gray-700 mb-2">Item yang dipesan:</p>
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <div class="flex items-center gap-4">
                                    <div class="bg-white p-1 rounded-lg shadow-sm">
                                        @if($item->menu->image)
                                            <img src="{{ asset('storage/' . $item->menu->image) }}" class="w-12 h-12 object-cover rounded-md">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-md flex items-center justify-center text-[10px]">NO IMG</div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $item->menu->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="font-black text-gray-700">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 pt-6 border-t border-dashed border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500 font-medium">Metode: <span class="text-gray-800 font-bold capitalize">{{ $order->payment_method }}</span></span>
                            <span class="mx-2 text-gray-300">|</span>
                            @if($order->payment_status == 'paid')
                                <span class="text-green-600 font-bold text-xs flex items-center gap-1">✅ Pembayaran Lunas</span>
                            @else
                                <span class="text-orange-500 font-bold text-xs flex items-center gap-1">⚠️ Belum Dibayar</span>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Total Bayar</p>
                            <p class="text-3xl font-black text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-5xl">🥡</span>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-800 mb-2">Tidak Ada Pesanan Aktif</h3>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">Kamu tidak memiliki pesanan yang sedang diproses. Yuk, cari makanan enak!</p>
                    <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        Pesan Sekarang
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>