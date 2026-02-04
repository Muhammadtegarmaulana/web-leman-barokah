<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                📜 Riwayat Pesanan
            </h2>
            <form action="{{ route('customer.orders.index') }}" method="GET" class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-600">Urutkan:</label>
                <select name="sort" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm focus:ring-indigo-500 shadow-sm">
                    <option value="terbaru" {{ $sort == 'terbaru' ? 'selected' : '' }}>Paling Baru</option>
                    <option value="terlama" {{ $sort == 'terlama' ? 'selected' : '' }}>Paling Lama</option>
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                
                @if($orders->isEmpty())
                    <div class="text-center py-16">
                        <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-4xl">🗒️</span>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada riwayat pesanan.</p>
                        <a href="{{ route('customer.dashboard') }}" class="mt-4 inline-block text-indigo-600 font-bold hover:underline">
                            Pesan makanan pertama kamu di sini →
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-2">
                            <thead>
                                <tr class="text-gray-500 text-sm uppercase tracking-wider">
                                    <th class="p-4 font-semibold">Tanggal</th>
                                    <th class="p-4 font-semibold">Tipe & Lokasi</th>
                                    <th class="p-4 font-semibold text-center">Total Bayar</th>
                                    <th class="p-4 font-semibold text-center">Pembayaran</th>
                                    <th class="p-4 font-semibold text-center">Status</th>
                                    <th class="p-4 font-semibold text-center">No. Antrian</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($orders as $order)
                                <tr class="bg-white hover:bg-gray-50 transition border border-gray-100 shadow-sm">
                                    <td class="p-4 text-sm text-gray-600">
                                        <div class="font-bold text-gray-800">{{ $order->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }} WIB</div>
                                    </td>
                                    
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800 capitalize">
                                            {{ $order->order_type == 'dine_in' ? '🍽️ Dine In' : '🛍️ Pickup' }}
                                        </div>
                                        @if($order->order_type == 'dine_in')
                                            <span class="text-[10px] bg-blue-50 text-blue-600 font-bold px-2 py-0.5 rounded border border-blue-100 uppercase">
                                                Meja {{ $order->table_number }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4 font-extrabold text-gray-800 text-center">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    
                                    <td class="p-4 text-center">
                                        @if($order->payment_status == 'paid')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[11px] font-bold border border-green-200">
                                                Lunas
                                            </span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-[11px] font-bold border border-yellow-200">
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-gray-100 text-gray-600',
                                                'processing' => 'bg-blue-100 text-blue-700 animate-pulse',
                                                'ready' => 'bg-emerald-100 text-emerald-700',
                                                'completed' => 'bg-indigo-100 text-indigo-700',
                                            ];
                                            $color = $statusColors[$order->order_status] ?? 'bg-gray-100';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold border border-opacity-20 {{ $color }} uppercase tracking-tighter">
                                            {{ $order->order_status }}
                                        </span>
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($order->queue_number)
                                            <div class="bg-indigo-600 text-white rounded-xl py-1 px-3 shadow-sm inline-block min-w-[60px]">
                                                <div class="text-[10px] uppercase opacity-80 leading-tight">Antrian</div>
                                                <div class="text-lg font-black leading-tight">{{ $order->queue_number }}</div>
                                            </div>
                                        @else
                                            <span class="text-[10px] text-gray-400 font-medium italic">Belum Terbit</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 border-t border-gray-100 pt-6">
                        {{ $orders->appends(['sort' => $sort])->links() }}
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>