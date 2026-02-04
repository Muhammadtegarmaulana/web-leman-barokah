<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                🍽️ Daftar Menu Restoran
            </h2>
            <a href="{{ route('admin.menus.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-full shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Menu Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <form action="{{ route('admin.menus.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-grow w-full">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Cari Nama Menu</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: Nasi Goreng..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                        </div>
                    </div>

                    <div class="w-full md:w-48">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Kategori</label>
                        <select name="category" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5">
                            <option value="semua">Semua</option>
                            <option value="makanan" {{ request('category') == 'makanan' ? 'selected' : '' }}>🍛 Makanan</option>
                            <option value="minuman" {{ request('category') == 'minuman' ? 'selected' : '' }}>🥤 Minuman</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full md:w-auto bg-gray-800 text-white px-8 py-2.5 rounded-xl font-bold hover:bg-black transition shadow-md">
                        Cari
                    </button>

                    @if(request('search') || request('category'))
                        <a href="{{ route('admin.menus.index') }}" class="w-full md:w-auto bg-red-50 text-red-600 px-4 py-2.5 rounded-xl font-bold hover:bg-red-100 transition text-center">
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
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info Menu</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Stok</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($menus as $menu)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-14 w-14">
                                            @if($menu->image)
                                                <img class="h-14 w-14 rounded-xl object-cover shadow-sm border border-gray-100" src="{{ asset('storage/' . $menu->image) }}" alt="">
                                            @else
                                                <div class="h-14 w-14 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400 text-[10px] font-bold">NO IMG</div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $menu->name }}</div>
                                            <div class="text-xs text-gray-500 truncate max-w-[200px]">{{ $menu->description }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full {{ $menu->category == 'makanan' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }} uppercase">
                                        {{ $menu->category }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-black text-gray-700">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($menu->is_available)
                                        <span class="text-green-600 flex items-center justify-center gap-1 font-bold text-xs">
                                            <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span> Tersedia
                                        </span>
                                    @else
                                        <span class="text-red-500 flex items-center justify-center gap-1 font-bold text-xs opacity-60">
                                            <span class="h-2 w-2 rounded-full bg-red-500"></span> Habis
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center items-center space-x-2">
                                        <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-indigo-600 hover:bg-indigo-50 p-2 rounded-xl transition" title="Edit Menu">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        
                                        <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="delete-form inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-500 hover:bg-red-50 p-2 rounded-xl transition btn-delete" data-name="{{ $menu->name }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-gray-100 p-4 rounded-full mb-4">🔍</div>
                                        <h3 class="text-gray-500 font-bold">Menu tidak ditemukan</h3>
                                        <p class="text-gray-400 text-sm">Coba cari dengan kata kunci lain atau kategori berbeda.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                {{ $menus->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');
                    const name = this.getAttribute('data-name');

                    Swal.fire({
                        title: 'Hapus Menu?',
                        text: `Menu "${name}" akan dihapus permanen dari daftar.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Menghapus...',
                                allowOutsideClick: false,
                                didOpen: () => { Swal.showLoading(); }
                            });
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>