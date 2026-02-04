<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // 1. Bersihkan folder storage/menus dulu agar tidak menumpuk sampah
        Storage::disk('public')->deleteDirectory('menus');
        Storage::disk('public')->makeDirectory('menus');

        $menus = [
            // MAKANAN
            ['name' => 'Nasi Goreng Spesial', 'price' => 25000, 'category' => 'makanan', 'keyword' => 'fried-rice'],
            ['name' => 'Ayam Bakar Madu', 'price' => 28000, 'category' => 'makanan', 'keyword' => 'grilled-chicken'],
            ['name' => 'Mie Aceh Daging', 'price' => 22000, 'category' => 'makanan', 'keyword' => 'noodles'],
            ['name' => 'Sate Padang', 'price' => 28000, 'category' => 'makanan', 'keyword' => 'satay'],
            ['name' => 'Soto Medan', 'price' => 25000, 'category' => 'makanan', 'keyword' => 'soup'],
            ['name' => 'Ikan Nila Bakar', 'price' => 35000, 'category' => 'makanan', 'keyword' => 'grilled-fish'],
            ['name' => 'Bebek Goreng', 'price' => 38000, 'category' => 'makanan', 'keyword' => 'fried-duck'],
            ['name' => 'Dimsum Ayam', 'price' => 18000, 'category' => 'makanan', 'keyword' => 'dimsum'],
            ['name' => 'Kentang Goreng', 'price' => 15000, 'category' => 'makanan', 'keyword' => 'french-fries'],
            
            // MINUMAN
            ['name' => 'Kopi Sanger', 'price' => 12000, 'category' => 'minuman', 'keyword' => 'coffee'],
            ['name' => 'Es Kopi Gula Aren', 'price' => 18000, 'category' => 'minuman', 'keyword' => 'iced-coffee'],
            ['name' => 'Jus Alpukat', 'price' => 18000, 'category' => 'minuman', 'keyword' => 'avocado-juice'],
            ['name' => 'Es Jeruk Peras', 'price' => 10000, 'category' => 'minuman', 'keyword' => 'orange-juice'],
            ['name' => 'Soda Gembira', 'price' => 15000, 'category' => 'minuman', 'keyword' => 'soda-drink'],
            ['name' => 'Milkshake Coklat', 'price' => 20000, 'category' => 'minuman', 'keyword' => 'milkshake'],
            ['name' => 'Es Teh Manis', 'price' => 5000, 'category' => 'minuman', 'keyword' => 'iced-tea'],
        ];

        foreach ($menus as $item) {
            // Membuat nama file unik
            $fileName = 'menus/' . Str::slug($item['name']) . '.jpg';
            
            // Ambil gambar dari Unsplash (Source random berdasarkan keyword)
            // Kita pakai @ untuk menghindari error jika koneksi internet mati
            try {
                $imageUrl = "https://loremflickr.com/400/400/" . $item['keyword'];
                $imageContent = file_get_contents($imageUrl);
                Storage::disk('public')->put($fileName, $imageContent);
            } catch (\Exception $e) {
                $fileName = null; // Jika gagal download, set null
            }

            Menu::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'category' => $item['category'],
                'description' => 'Menu lezat kualitas premium dari Leman Barokah. Dibuat dengan bahan segar setiap hari.',
                'image' => $fileName,
                'is_available' => true
            ]);
        }
    }
}