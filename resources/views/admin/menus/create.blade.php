<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            ✨ Tambah Menu Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-gray-100">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0"><svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg></div>
                            <div class="ml-3">
                                <h3 class="text-sm leading-5 font-medium text-red-800">Terdapat kesalahan input:</h3>
                                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Menu</label>
                            <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition" placeholder="Contoh: Nasi Goreng Spesial" value="{{ old('name') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                            <input type="number" name="price" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="15000" value="{{ old('price') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="category" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                <option value="makanan">🍛 Makanan</option>
                                <option value="minuman">🥤 Minuman</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Jelaskan detail menu...">{{ old('description') }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Foto Menu</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="image-upload" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden group">
                                    
                                    <div id="image-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="text-sm text-gray-500 group-hover:text-indigo-600 transition"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-500 mt-1">JPG, PNG (MAX. 2MB)</p>
                                    </div>

                                    <img id="image-preview" src="#" alt="Preview Gambar" class="hidden absolute inset-0 w-full h-full object-cover" />

                                    <input id="image-upload" type="file" name="image" class="hidden" accept="image/*" onchange="previewImage(event)" required />
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('admin.menus.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">Batal</a>
                        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition transform hover:-translate-y-1">
                            Simpan Menu
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();
            
            reader.onload = function() {
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-placeholder');
                
                // Set source gambar ke hasil bacaan file
                preview.src = reader.result;
                
                // Tampilkan gambar, sembunyikan placeholder
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            
            // Baca file jika ada
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>