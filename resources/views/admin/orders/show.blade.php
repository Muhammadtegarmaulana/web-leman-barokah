<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                📦 Detail Pesanan #{{ $order->id }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900 font-bold">
                < Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Item Pesanan</h3>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-sm text-gray-500">
                                <th class="pb-2">Menu</th>
                                <th class="pb-2 text-center">Qty</th>
                                <th class="pb-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td class="py-3 flex items-center">
                                    <img src="{{ asset('storage/' . $item->menu->image) }}" class="w-12 h-12 rounded object-cover mr-3">
                                    <div>
                                        <div class="font-bold">{{ $item->menu->name }}</div>
                                        <div class="text-xs text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                    </div>
                                </td>
                                <td class="py-3 text-center font-bold">{{ $item->quantity }}</td>
                                <td class="py-3 text-right font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-gray-200">
                                <td colspan="2" class="pt-4 text-right font-bold text-gray-600">Total Harga:</td>
                                <td class="pt-4 text-right font-extrabold text-xl text-indigo-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="mt-8 bg-gray-50 p-4 rounded-xl">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="block text-gray-500">Nama Customer:</span>
                                <span class="font-bold text-gray-800">{{ $order->user->name }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500">Tipe Pesanan:</span>
                                <span class="font-bold uppercase">{{ $order->order_type }}</span>
                                @if($order->table_number) (Meja {{ $order->table_number }}) @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1 space-y-6">
                    
                    <div class="bg-white shadow-xl sm:rounded-2xl p-6 border border-gray-100">
                        <h3 class="font-bold text-gray-700 mb-4">Status Pembayaran</h3>
                        
                        @if($order->payment_status == 'unpaid')
                            <div class="mb-4">
                                <div class="text-xs font-bold uppercase text-gray-500 mb-1">Metode Bayar</div>
                                <div class="font-bold text-lg mb-2">{{ ucfirst($order->payment_method) }}</div>
                                
                                @if($order->payment_method == 'transfer' && $order->payment_proof)
                                    <div class="mb-4">
                                        <p class="text-xs mb-2">Bukti Transfer:</p>
                                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full rounded-lg border hover:opacity-75 cursor-zoom-in">
                                        </a>
                                    </div>
                                @elseif($order->payment_method == 'transfer')
                                    <div class="text-red-500 text-sm italic mb-4">Bukti belum diupload customer.</div>
                                @endif
                            </div>

                            <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" id="form-confirm-pay">
                                @csrf
                                <button type="button" class="btn-confirm-pay w-full bg-green-600 text-white font-bold py-3 rounded-xl shadow hover:bg-green-700 transition">
                                    ✅ Konfirmasi & Terbitkan Antrian
                                </button>
                            </form>
                        @else
                            <div class="bg-green-100 text-green-800 p-4 rounded-xl text-center">
                                <div class="font-bold text-lg">LUNAS</div>
                                <div class="text-sm">No. Antrian:</div>
                                <div class="text-4xl font-extrabold my-2">{{ $order->queue_number }}</div>
                            </div>
                        @endif
                    </div>

                    @if($order->payment_status == 'paid')
                    <div class="bg-white shadow-xl sm:rounded-2xl p-6 border border-gray-100">
                        <h3 class="font-bold text-gray-700 mb-4">Proses Dapur</h3>
                        
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-2">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="status" value="processing" {{ $order->order_status == 'processing' ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="ml-2 font-bold text-blue-600">🔥 Sedang Dimasak</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="status" value="ready" {{ $order->order_status == 'ready' ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="ml-2 font-bold text-green-600">🔔 Siap Diambil</span>
                                </label>
                            </div>
                        </form>

                        @if($order->order_status == 'ready')
                            <div class="mt-6 border-t pt-4">
                                <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST" id="form-complete-order">
                                    @csrf
                                    <button type="button" class="btn-complete-order w-full bg-gray-800 text-white font-bold py-3 rounded-xl hover:bg-black transition">
                                        🏁 Selesai (Customer Sudah Ambil)
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // 1. Konfirmasi Pembayaran
            const btnPay = document.querySelector('.btn-confirm-pay');
            if(btnPay) {
                btnPay.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Konfirmasi Pembayaran?',
                        text: "Sistem akan menerbitkan Nomor Antrian.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10B981', // Hijau
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Terbitkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({ title: 'Memproses...', didOpen: () => Swal.showLoading() });
                            document.getElementById('form-confirm-pay').submit();
                        }
                    });
                });
            }

            // 2. Konfirmasi Selesai Order
            const btnComplete = document.querySelector('.btn-complete-order');
            if(btnComplete) {
                btnComplete.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Pesanan Selesai?',
                        text: "Pastikan customer sudah mengambil pesanan. Data akan diarsipkan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#1F2937', // Hitam/Abu gelap
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Selesai!',
                        cancelButtonText: 'Belum'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({ title: 'Menyimpan...', didOpen: () => Swal.showLoading() });
                            document.getElementById('form-complete-order').submit();
                        }
                    });
                });
            }

        });
    </script>

</x-app-layout>