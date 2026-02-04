<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                📋 Manajemen Pesanan Aktif
            </h2>
            <div class="flex items-center gap-2 bg-indigo-50 px-4 py-2 rounded-full border border-indigo-100">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                </span>
                <span class="text-sm font-bold text-indigo-700">Live Monitor Antrian</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-grow w-full">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Cari Customer / ID</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau ID pesanan..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                        </div>
                    </div>

                    <div class="w-full md:w-56">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Status Antrian</label>
                        <select name="status" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 font-medium text-gray-700">
                            <option value="semua">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Menunggu (Pending)</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>🔥 Dimasak (Processing)</option>
                            <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>🔔 Siap (Ready)</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full md:w-auto bg-gray-900 text-white px-8 py-2.5 rounded-xl font-bold hover:bg-black transition shadow-md">
                        Filter
                    </button>

                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.orders.index') }}" class="w-full md:w-auto bg-gray-100 text-gray-600 px-4 py-2.5 rounded-xl font-bold hover:bg-gray-200 transition text-center">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe & Meja</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Total Harga</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Pembayaran</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Order</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                                            {{ substr($order->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $order->user->name }}</div>
                                            <div class="text-[10px] text-gray-400">ID: #{{ $order->id }} | {{ $order->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-xs font-bold uppercase {{ $order->order_type == 'dine_in' ? 'text-blue-600' : 'text-orange-600' }}">
                                        {{ $order->order_type == 'dine_in' ? '🍽️ Dine In' : '🛍️ Pickup' }}
                                    </div>
                                    @if($order->table_number)
                                        <div class="text-[10px] text-gray-500">No. Meja: {{ $order->table_number }}</div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-black text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($order->payment_status == 'paid')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full border border-green-200">LUNAS</span>
                                    @else
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-bold rounded-full border border-yellow-200">BELUM BAYAR</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-gray-100 text-gray-600 border-gray-200',
                                            'processing' => 'bg-blue-50 text-blue-600 border-blue-200 animate-pulse',
                                            'ready' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        ];
                                        $colorClass = $statusColors[$order->order_status] ?? 'bg-gray-50';
                                    @endphp
                                    <span class="px-3 py-1 {{ $colorClass }} text-[10px] font-black rounded-full border uppercase tracking-widest">
                                        {{ $order->order_status }}
                                    </span>
                                    @if($order->queue_number)
                                        <div class="mt-1 text-sm font-black text-indigo-600">#{{ $order->queue_number }}</div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-indigo-600 text-indigo-600 text-xs font-bold rounded-xl hover:bg-indigo-600 hover:text-white transition shadow-sm">
                                        Proses
                                        <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-gray-50 p-5 rounded-full mb-4">✨</div>
                                        <h3 class="text-gray-500 font-bold">Tidak ada pesanan aktif</h3>
                                        <p class="text-gray-400 text-sm">Semua pesanan sudah diproses atau tidak ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>

        </div>
    </div>
</x-app-layout>