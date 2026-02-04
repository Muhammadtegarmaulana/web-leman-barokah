<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // 1. Tampilkan Daftar Menu
    public function index(Request $request)
    {
        $query = Menu::query();

        // Search by Name
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by Category
        if ($request->category && $request->category != 'semua') {
            $query->where('category', $request->category);
        }

        $menus = $query->latest()->paginate(10)->withQueryString();
        return view('admin.menus.index', compact('menus'));
    }

    // 2. Tampilkan Form Tambah
    public function create()
    {
        return view('admin.menus.create');
    }

    // 3. Proses Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu-images', 'public');
        }

        Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'category' => $request->category,
            'description' => $request->description,
            'is_available' => true,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // --- TAMBAHAN BARU DI BAWAH INI ---

    // 4. Tampilkan Form Edit
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus.edit', compact('menu'));
    }

    // 5. Proses Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'image' => 'nullable|image|max:2048', // Image boleh kosong saat edit
        ]);

        $menu = Menu::findOrFail($id);

        // Update data dasar
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'is_available' => $request->has('is_available') ? true : false,
        ];

        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('menu-images', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui!');
    }

    // 6. Proses Hapus Data
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus file gambar dari storage biar tidak nyampah
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus!');
    }
}