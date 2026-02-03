<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            ✏️ Edit Menu: {{ $menu->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-gray-100">
                
                <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <div class="col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Foto Saat Ini</label>
                            <div class="rounded-xl overflow-hidden shadow-md border border-gray-200">
                                <img src="{{ asset('storage/' . $menu->image) }}" class="w-full h-auto object-cover" alt="Foto Lama">
                            </div>
                            <p class="text-xs text-center text-gray-500 mt-2">Biarkan input foto kosong jika tidak ingin mengubah gambar.</p>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <div class="grid grid-cols-1 gap-6">
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Menu</label>
                                    <input type="text" name="name" value="{{ $menu->name }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                                        <input type="number" name="price" value="{{ $menu->price }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                                        <select name="category" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                            <option value="makanan" {{ $menu->category == 'makanan' ? 'selected' : '' }}>🍛 Makanan</option>
                                            <option value="minuman" {{ $menu->category == 'minuman' ? 'selected' : '' }}>🥤 Minuman</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_available" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-5 w-5" {{ $menu->is_available ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-800 font-bold">Stok Tersedia?</span>
                                    </label>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ $menu->description }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Ganti Foto (Opsional)</label>
                                    <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                                </div>

                                <div class="flex justify-end gap-4 mt-4">
                                    <a href="{{ route('admin.menus.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">Batal</a>
                                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition">
                                        Update Menu
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>