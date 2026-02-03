<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            📈 Laporan Pendapatan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 no-print">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md font-bold hover:bg-indigo-700">
                        Filter
                    </button>
                    <button type="button" onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-md font-bold hover:bg-gray-900 ml-auto">
                        🖨️ Cetak Laporan
                    </button>
                </form>
            </div>

            <div class="bg-indigo-600 text-white rounded-xl shadow-lg p-6 mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold opacity-80">Total Pendapatan ({{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})</h3>
                </div>
                <div class="text-4xl font-extrabold">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Rincian Transaksi</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="p-3 text-sm">Tanggal</th>
                            <th class="p-3 text-sm">No. Antrian</th>
                            <th class="p-3 text-sm">Customer</th>
                            <th class="p-3 text-sm">Tipe</th>
                            <th class="p-3 text-sm text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                        <tr>
                            <td class="p-3 text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-3 font-bold text-indigo-600">{{ $order->queue_number ?? '-' }}</td>
                            <td class="p-3 text-sm">{{ $order->user->name }}</td>
                            <td class="p-3 text-sm capitalize">{{ $order->order_type }}</td>
                            <td class="p-3 font-bold text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">Tidak ada data transaksi pada rentang tanggal ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <style>
        @media print {
            .no-print, nav, header { display: none !important; }
            body { background: white; }
            .shadow-xl, .shadow-lg { box-shadow: none !important; }
        }
    </style>
</x-app-layout>