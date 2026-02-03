<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            📋 Daftar Pesanan Masuk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="p-4">Customer</th>
                            <th class="p-4">Tipe</th>
                            <th class="p-4">Total</th>
                            <th class="p-4 text-center">Bukti Bayar</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="font-bold">{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $order->created_at->format('d M H:i') }}</div>
                            </td>
                            <td class="p-4">
                                <span class="uppercase font-bold text-xs bg-gray-200 px-2 py-1 rounded">
                                    {{ $order->order_type }}
                                </span>
                                @if($order->table_number)
                                    <div class="text-xs mt-1">Meja: {{ $order->table_number }}</div>
                                @endif
                            </td>
                            <td class="p-4 font-bold text-indigo-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            
                            <td class="p-4 text-center">
                                @if($order->payment_status == 'paid')
                                    <span class="text-green-600 font-bold text-xs">✅ LUNAS</span>
                                @else
                                    @if($order->payment_method == 'transfer')
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 underline text-xs">Cek Bukti TF</a>
                                    @else
                                        <span class="text-yellow-600 text-xs font-bold">💵 Cash (Kasir)</span>
                                    @endif
                                @endif
                            </td>

                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                    {{ $order->order_status == 'pending' ? 'bg-gray-200 text-gray-700' : '' }}
                                    {{ $order->order_status == 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $order->order_status == 'ready' ? 'bg-green-100 text-green-700' : '' }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                                @if($order->queue_number)
                                    <div class="mt-1 font-bold text-indigo-600">No: {{ $order->queue_number }}</div>
                                @endif
                            </td>

                            <td class="p-4 text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-indigo-700">
                                    Proses >
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($orders->isEmpty())
                    <div class="text-center py-10 text-gray-500">Tidak ada pesanan aktif saat ini.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>