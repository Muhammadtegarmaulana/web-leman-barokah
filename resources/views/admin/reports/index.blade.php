<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 print:hidden">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                📈 Laporan Keuangan & Penjualan
            </h2>
            <button onclick="window.print()" class="bg-gray-800 hover:bg-black text-white font-bold py-2.5 px-6 rounded-xl shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 print:mb-4">
                <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="text-indigo-200 text-xs font-bold uppercase tracking-wider mb-1">Total Omset Periode Ini</div>
                        <div class="text-3xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    </div>
                    <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-4 translate-y-4">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-center">
                    <div class="text-gray-400 text-xs font-bold uppercase mb-2">Periode Laporan</div>
                    <div class="flex items-center gap-2 text-gray-800 font-bold text-lg">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} 
                        <span class="text-gray-400 mx-1">-</span>
                        {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-center">
                    <div class="text-gray-400 text-xs font-bold uppercase mb-2">Total Transaksi Berhasil</div>
                    <div class="text-3xl font-black text-gray-800">{{ $orders->total() }} <span class="text-sm font-medium text-gray-400">Pesanan</span></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 print:hidden">
                <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5">
                    </div>
                    <div class="w-full">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5">
                    </div>
                    <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white px-8 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-md">
                        Tampilkan
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 print:shadow-none print:border-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 print:bg-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe Order</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Metode Bayar</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition print:hover:bg-transparent">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $order->created_at->format('d/m/Y') }}
                                    <span class="text-xs text-gray-400 block">{{ $order->created_at->format('H:i') }}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-[10px] text-gray-400">Order ID: #{{ $order->id }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border {{ $order->order_type == 'dine_in' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-orange-50 text-orange-600 border-orange-100' }}">
                                        {{ $order->order_type == 'dine_in' ? 'Dine In' : 'Pickup' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600 capitalize">
                                    {{ $order->payment_method }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right font-black text-gray-800">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                    Tidak ada data transaksi pada periode ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50 print:bg-gray-100 font-bold text-gray-700">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right uppercase text-xs tracking-wider">Subtotal Halaman Ini</td>
                                <td class="px-6 py-4 text-right">Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="mt-8 print:hidden">
                {{ $orders->links() }}
            </div>
            
            <div class="hidden print:flex justify-end mt-16 pr-10">
                <div class="text-center">
                    <p class="mb-20">Medan, {{ date('d F Y') }}</p>
                    <p class="font-bold underline">{{ Auth::user()->name }}</p>
                    <p class="text-sm">Manager Operasional</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>