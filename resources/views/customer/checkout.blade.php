<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            💳 Konfirmasi Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-8">
                
                <form action="{{ route('place_order') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">Detail Pesanan</h3>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mau Makan Dimana?</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="order_type" value="dine_in" class="peer sr-only" onchange="toggleTableInput()" checked>
                                <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition text-center">
                                    <div class="font-bold text-gray-700 peer-checked:text-indigo-700">🍽️ Dine In</div>
                                    <div class="text-xs text-gray-500">Makan di Tempat</div>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="order_type" value="pickup" class="peer sr-only" onchange="toggleTableInput()">
                                <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition text-center">
                                    <div class="font-bold text-gray-700 peer-checked:text-indigo-700">🛍️ Pickup</div>
                                    <div class="text-xs text-gray-500">Ambil Sendiri</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6" id="table_input_div">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Meja</label>
                        <input type="number" name="table_number" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Contoh: 5">
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2 mt-8">Pembayaran</h3>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Metode Pembayaran</label>
                        <select name="payment_method" id="payment_method" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" onchange="toggleProofInput()">
                            <option value="cash">💵 Cash (Bayar di Kasir)</option>
                            <option value="transfer">🏦 Transfer Bank (Upload Bukti)</option>
                        </select>
                    </div>

                    <div class="mb-6 hidden" id="proof_input_div">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-blue-800 font-bold mb-1">Info Rekening:</p>
                            <p class="text-lg font-mono font-bold text-blue-900">BCA: 123-456-7890</p>
                            <p class="text-sm text-blue-700">a.n Leman Barokah</p>
                        </div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload Bukti Transfer</label>
                        <input type="file" name="payment_proof" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                    </div>

                    <button type="submit" class="w-full mt-6 bg-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-xl transition transform hover:-translate-y-1">
                        ✅ Buat Pesanan Sekarang
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function toggleTableInput() {
            // Cek radio button mana yang checked
            var isPickup = document.querySelector('input[name="order_type"]:checked').value === "pickup";
            var div = document.getElementById("table_input_div");
            if (isPickup) {
                div.style.display = "none";
            } else {
                div.style.display = "block";
            }
        }

        function toggleProofInput() {
            var method = document.getElementById("payment_method").value;
            var div = document.getElementById("proof_input_div");
            if (method === "transfer") {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        }
    </script>
</x-app-layout>