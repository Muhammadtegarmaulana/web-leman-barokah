<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            🚀 Dashboard Overview
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-b-4 border-green-500 p-6 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-bold uppercase">Pendapatan Hari Ini</div>
                        <div class="text-2xl font-extrabold text-gray-800 mt-1">
                            Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-b-4 border-blue-500 p-6 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-bold uppercase">Order Hari Ini</div>
                        <div class="text-2xl font-extrabold text-gray-800 mt-1">
                            {{ $todayOrdersCount }} <span class="text-sm text-gray-400 font-normal">Pesanan</span>
                        </div>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-b-4 border-orange-500 p-6 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-bold uppercase">Antrian Aktif</div>
                        <div class="text-2xl font-extrabold text-orange-600 mt-1">
                            {{ $activeOrders }} <span class="text-sm text-gray-400 font-normal">Menunggu</span>
                        </div>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full text-orange-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-b-4 border-purple-500 p-6 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-bold uppercase">Total Menu</div>
                        <div class="text-2xl font-extrabold text-gray-800 mt-1">
                            {{ $totalMenus }} <span class="text-sm text-gray-400 font-normal">Item</span>
                        </div>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg text-gray-800">Pesanan Masuk Terbaru</h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 text-sm font-bold hover:underline">Lihat Semua ></a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 text-xs font-bold text-gray-500 uppercase">Customer</th>
                                    <th class="p-3 text-xs font-bold text-gray-500 uppercase">Total</th>
                                    <th class="p-3 text-xs font-bold text-gray-500 uppercase text-center">Status</th>
                                    <th class="p-3 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($latestOrders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3">
                                        <div class="font-bold text-sm">{{ $order->user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="p-3 font-bold text-sm text-gray-700">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3 text-center">
                                        @if($order->payment_status == 'paid')
                                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Lunas</span>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs font-bold border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50">
                                            Proses
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-400 text-sm">Belum ada pesanan hari ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <a href="{{ route('admin.orders.index') }}" class="flex items-center p-4 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition border border-indigo-100">
                            <div class="p-3 bg-indigo-600 text-white rounded-lg mr-4">
                                📋
                            </div>
                            <div>
                                <div class="font-bold text-indigo-900">Proses Pesanan</div>
                                <div class="text-xs text-indigo-600">Cek orderan masuk</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.menus.create') }}" class="flex items-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition border border-green-100">
                            <div class="p-3 bg-green-600 text-white rounded-lg mr-4">
                                🍔
                            </div>
                            <div>
                                <div class="font-bold text-green-900">Tambah Menu</div>
                                <div class="text-xs text-green-600">Input makanan baru</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.reports.index') }}" class="flex items-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition border border-purple-100">
                            <div class="p-3 bg-purple-600 text-white rounded-lg mr-4">
                                📊
                            </div>
                            <div>
                                <div class="font-bold text-purple-900">Laporan Keuangan</div>
                                <div class="text-xs text-purple-600">Cek omset bulanan</div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>