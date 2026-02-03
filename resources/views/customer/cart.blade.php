<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            🛒 Keranjang Belanja
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-8">
                
                @if(session('cart') && count(session('cart')) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-400 border-b border-gray-100">
                                    <th class="py-4 text-sm font-semibold uppercase">Menu</th>
                                    <th class="py-4 text-sm font-semibold uppercase">Harga</th>
                                    <th class="py-4 text-sm font-semibold uppercase text-center">Qty</th>
                                    <th class="py-4 text-sm font-semibold uppercase">Total</th>
                                    <th class="py-4 text-sm font-semibold uppercase text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @php $total = 0; @endphp
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 flex items-center">
                                            <img src="{{ asset('storage/' . $details['image']) }}" class="w-12 h-12 rounded-lg object-cover mr-4 shadow-sm">
                                            <span class="font-bold text-gray-700">{{ $details['name'] }}</span>
                                        </td>
                                        <td class="py-4 text-gray-600">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                        <td class="py-4 text-center">
                                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-lg font-bold">{{ $details['quantity'] }}</span>
                                        </td>
                                        <td class="py-4 font-bold text-indigo-600">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                                        <td class="py-4 text-right">
                                            <button class="text-red-500 hover:text-red-700 font-bold text-sm remove-from-cart" data-id="{{ $id }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 flex flex-col md:flex-row justify-between items-center bg-gray-50 p-6 rounded-xl">
                        <div class="text-gray-500 mb-4 md:mb-0">
                            Total Pembayaran:
                            <div class="text-3xl font-extrabold text-gray-900 mt-1">Rp {{ number_format($total, 0, ',', '.') }}</div>
                        </div>
                        <div class="flex gap-4">
                            <a href="{{ route('customer.dashboard') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition">
                                < Tambah Menu Lain
                            </a>
                            <a href="{{ route('checkout') }}" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-xl transition transform hover:-translate-y-1">
                                Lanjut Pembayaran >
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-10">
                        <div class="text-6xl mb-4">🛒</div>
                        <h3 class="text-xl font-bold text-gray-800">Keranjang masih kosong</h3>
                        <p class="text-gray-500 mb-6">Yuk pesan makanan kesukaanmu sekarang!</p>
                        <a href="{{ route('customer.dashboard') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">
                            Lihat Menu
                        </a>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if(confirm("Yakin ingin menghapus menu ini?")) {
                $.ajax({
                    url: '{{ route('remove_from_cart') }}',
                    method: "DELETE",
                    data: { _token: '{{ csrf_token() }}', id: ele.attr("data-id") },
                    success: function (response) { window.location.reload(); }
                });
            }
        });
    </script>
</x-app-layout>