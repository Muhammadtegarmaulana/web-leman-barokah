<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            🛒 Keranjang Belanja
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-8">
                
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm flex items-center">
                        <span class="text-green-500 mr-2">✅</span>
                        <p class="text-green-700 font-bold">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('cart') && count(session('cart')) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-400 border-b border-gray-100">
                                    <th class="py-4 text-sm font-semibold uppercase">Menu</th>
                                    <th class="py-4 text-sm font-semibold uppercase">Harga</th>
                                    <th class="py-4 text-sm font-semibold uppercase text-center">Qty</th>
                                    <th class="py-4 text-sm font-semibold uppercase text-right">Subtotal</th>
                                    <th class="py-4 text-sm font-semibold uppercase text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @php $total = 0; @endphp
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr class="hover:bg-gray-50 transition group">
                                        <td class="py-4 flex items-center">
                                            <img src="{{ asset('storage/' . $details['image']) }}" class="w-16 h-16 rounded-xl object-cover mr-4 shadow-sm border border-gray-200">
                                            <div>
                                                <div class="font-bold text-gray-700 text-lg">{{ $details['name'] }}</div>
                                                <div class="text-xs text-gray-400">Enak & Lezat</div>
                                            </div>
                                        </td>
                                        
                                        <td class="py-4 text-gray-600 font-medium">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                        
                                        <td class="py-4 text-center">
                                            <div class="inline-flex items-center bg-gray-100 rounded-lg p-1">
                                                <button class="change-qty bg-white text-gray-600 hover:text-red-500 hover:bg-red-50 w-8 h-8 rounded-md shadow-sm font-bold transition" 
                                                    data-id="{{ $id }}" data-action="minus">
                                                    -
                                                </button>
                                                
                                                <span class="mx-4 font-bold text-gray-800 w-4 text-center">{{ $details['quantity'] }}</span>
                                                
                                                <button class="change-qty bg-white text-gray-600 hover:text-green-500 hover:bg-green-50 w-8 h-8 rounded-md shadow-sm font-bold transition" 
                                                    data-id="{{ $id }}" data-action="plus">
                                                    +
                                                </button>
                                            </div>
                                        </td>

                                        <td class="py-4 text-right font-bold text-indigo-600 text-lg">
                                            Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                        </td>

                                        <td class="py-4 text-right">
                                            <button class="text-gray-400 hover:text-red-500 transition p-2 remove-from-cart" data-id="{{ $id }}" title="Hapus Item">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 flex flex-col md:flex-row justify-between items-center bg-gray-50 p-6 rounded-2xl border border-gray-200">
                        <div class="text-gray-500 mb-4 md:mb-0">
                            <span class="block text-xs uppercase font-bold tracking-wider mb-1">Total Pembayaran</span>
                            <div class="text-3xl font-extrabold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</div>
                        </div>
                        <div class="flex gap-4">
                            <a href="{{ route('customer.dashboard') }}" class="px-6 py-4 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                                < Tambah Menu Lain
                            </a>
                            <a href="{{ route('checkout') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-xl transition transform hover:-translate-y-1 flex items-center">
                                Lanjut Pembayaran 
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-4xl">🛒</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Keranjangmu Kosong</h3>
                        <p class="text-gray-500 mb-8 max-w-sm mx-auto">Sepertinya kamu belum memesan makanan lezat hari ini. Yuk cek menu kami!</p>
                        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg">
                            Lihat Menu Sekarang
                        </a>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        
        // 1. UPDATE QUANTITY (Tambah / Kurang)
        $(".change-qty").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            var id = ele.attr("data-id");
            var action = ele.attr("data-action");

            $.ajax({
                url: '{{ route('update_cart') }}',
                method: "PATCH",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: id, 
                    action: action
                },
                success: function (response) {
                    // Reload halaman agar total harga terupdate dari server
                    window.location.reload();
                }
            });
        });

        // 2. HAPUS ITEM (Tombol Sampah)
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            
            if(confirm("Yakin ingin menghapus menu ini dari keranjang?")) {
                $.ajax({
                    url: '{{ route('remove_from_cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        id: ele.attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
</x-app-layout>