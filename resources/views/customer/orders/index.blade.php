<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            📜 Riwayat Pesanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                
                @if($orders->isEmpty())
                    <div class="text-center py-10">
                        <p class="text-gray-500">Belum ada riwayat pesanan.</p>
                        <a href="{{ route('customer.dashboard') }}" class="text-indigo-600 font-bold hover:underline">Pesan sekarang?</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Info Pesanan</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Total</th>
                                    <th class="p-4 text-center text-sm font-semibold text-gray-600">Pembayaran</th>
                                    <th class="p-4 text-center text-sm font-semibold text-gray-600">Status Order</th>
                                    <th class="p-4 text-center text-sm font-semibold text-gray-600">Antrian</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($orders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 text-sm text-gray-600">
                                        {{ $order->created_at->format('d M Y') }}<br>
                                        <span class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</span>
                                    </td>
                                    
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800 capitalize">{{ str_replace('_', ' ', $order->order_type) }}</div>
                                        @if($order->order_type == 'dine_in')
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Meja {{ $order->table_number }}</span>
                                        @endif
                                    </td>

                                    <td class="p-4 font-bold text-gray-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    
                                    <td class="p-4 text-center">
                                        @if($order->payment_status == 'paid')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">Lunas</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200">Belum Bayar</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-gray-100 text-gray-600',
                                                'processing' => 'bg-blue-100 text-blue-700 animate-pulse', // Efek kedip kalau diproses
                                                'ready' => 'bg-green-100 text-green-700',
                                                'completed' => 'bg-indigo-100 text-indigo-700',
                                            ];
                                            $color = $statusColors[$order->order_status] ?? 'bg-gray-100';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border border-opacity-20 {{ $color }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($order->queue_number)
                                            <div class="bg-indigo-600 text-white rounded-lg p-2 shadow-md">
                                                <div class="text-xs uppercase opacity-75">No. Antrian</div>
                                                <div class="text-xl font-extrabold">{{ $order->queue_number }}</div>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Menunggu...</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>