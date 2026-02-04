<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $menus = [
            // === MAKANAN BERAT ===
            [
                'name' => 'Nasi Goreng Spesial',
                'price' => 25000,
                'category' => 'makanan',
                'description' => 'Nasi goreng dengan toping ayam suwir, telur mata sapi, dan kerupuk udang.',
                'is_available' => true,
            ],
            [
                'name' => 'Nasi Goreng Kampung',
                'price' => 20000,
                'category' => 'makanan',
                'description' => 'Nasi goreng bumbu terasi pedas dengan ikan teri medan dan petai.',
                'is_available' => true,
            ],
            [
                'name' => 'Nasi Goreng Seafood',
                'price' => 30000,
                'category' => 'makanan',
                'description' => 'Nasi goreng dengan udang, cumi, dan bakso ikan.',
                'is_available' => true,
            ],
            [
                'name' => 'Ayam Bakar Madu',
                'price' => 28000,
                'category' => 'makanan',
                'description' => 'Ayam bakar dengan olesan madu murni, disajikan dengan lalapan segar.',
                'is_available' => true,
            ],
            [
                'name' => 'Ayam Penyet Sambal Ijo',
                'price' => 25000,
                'category' => 'makanan',
                'description' => 'Ayam goreng dipenyet dengan sambal ijo super pedas.',
                'is_available' => true,
            ],
            [
                'name' => 'Mie Gomak Goreng',
                'price' => 15000,
                'category' => 'makanan',
                'description' => 'Mie lidi khas Medan digoreng dengan bumbu andaliman.',
                'is_available' => true,
            ],
            [
                'name' => 'Mie Aceh Daging',
                'price' => 22000,
                'category' => 'makanan',
                'description' => 'Mie kuning tebal dengan kuah kari kental dan irisan daging sapi.',
                'is_available' => true,
            ],
            [
                'name' => 'Sate Padang',
                'price' => 28000,
                'category' => 'makanan',
                'description' => 'Sate daging sapi dengan kuah kuning kental kaya rempah.',
                'is_available' => false, // Sedang habis
            ],
            [
                'name' => 'Soto Medan',
                'price' => 25000,
                'category' => 'makanan',
                'description' => 'Soto bersantan gurih dengan isian ayam/daging dan perkedel.',
                'is_available' => true,
            ],
            [
                'name' => 'Ikan Nila Bakar',
                'price' => 35000,
                'category' => 'makanan',
                'description' => 'Ikan nila segar dibakar dengan bumbu kecap pedas manis.',
                'is_available' => true,
            ],
            [
                'name' => 'Bebek Goreng Surabaya',
                'price' => 38000,
                'category' => 'makanan',
                'description' => 'Bebek goreng empuk dengan bumbu hitam madura.',
                'is_available' => true,
            ],
            [
                'name' => 'Gado-gado Spesial',
                'price' => 18000,
                'category' => 'makanan',
                'description' => 'Sayuran rebus dengan bumbu kacang medok dan kerupuk.',
                'is_available' => true,
            ],

            // === CEMILAN / SNACK ===
            [
                'name' => 'Kentang Goreng',
                'price' => 15000,
                'category' => 'makanan',
                'description' => 'French fries renyah dengan saus sambal dan mayonaise.',
                'is_available' => true,
            ],
            [
                'name' => 'Pisang Bakar Coklat Keju',
                'price' => 15000,
                'category' => 'makanan',
                'description' => 'Pisang kepok bakar dengan topping melimpah.',
                'is_available' => true,
            ],
            [
                'name' => 'Roti Bakar Kaya',
                'price' => 12000,
                'category' => 'makanan',
                'description' => 'Roti bakar selai srikaya khas Medan.',
                'is_available' => true,
            ],
            [
                'name' => 'Dimsum Ayam (4pcs)',
                'price' => 18000,
                'category' => 'makanan',
                'description' => 'Siomay ayam udang kukus hangat.',
                'is_available' => true,
            ],

            // === MINUMAN (KOPI) ===
            [
                'name' => 'Kopi Sanger',
                'price' => 12000,
                'category' => 'minuman',
                'description' => 'Kopi susu khas Aceh yang ditarik saring.',
                'is_available' => true,
            ],
            [
                'name' => 'Kopi Hitam Gayo',
                'price' => 10000,
                'category' => 'minuman',
                'description' => 'Kopi arabika gayo asli tanpa gula.',
                'is_available' => true,
            ],
            [
                'name' => 'Es Kopi Susu Gula Aren',
                'price' => 18000,
                'category' => 'minuman',
                'description' => 'Kopi susu kekinian dengan gula aren asli.',
                'is_available' => true,
            ],
            [
                'name' => 'Cappuccino Dingin',
                'price' => 20000,
                'category' => 'minuman',
                'description' => 'Espresso dengan fresh milk dan foam tebal.',
                'is_available' => true,
            ],

            // === MINUMAN (NON KOPI) ===
            [
                'name' => 'Es Teh Manis Jumbo',
                'price' => 5000,
                'category' => 'minuman',
                'description' => 'Teh manis dingin ukuran jumbo segarnya nampol.',
                'is_available' => true,
            ],
            [
                'name' => 'Es Jeruk Peras',
                'price' => 10000,
                'category' => 'minuman',
                'description' => 'Jeruk peras murni segar.',
                'is_available' => true,
            ],
            [
                'name' => 'Jus Alpukat Kocok',
                'price' => 18000,
                'category' => 'minuman',
                'description' => 'Alpukat mentega dikocok dengan susu kental manis coklat.',
                'is_available' => true,
            ],
            [
                'name' => 'Jus Mangga',
                'price' => 15000,
                'category' => 'minuman',
                'description' => 'Jus mangga harum manis kental.',
                'is_available' => true,
            ],
            [
                'name' => 'Es Timun Serut',
                'price' => 12000,
                'category' => 'minuman',
                'description' => 'Minuman segar serutan timun dan sirup melon.',
                'is_available' => true,
            ],
            [
                'name' => 'Soda Gembira',
                'price' => 15000,
                'category' => 'minuman',
                'description' => 'Soda, sirup coco pandan, dan susu kental manis.',
                'is_available' => true,
            ],
            [
                'name' => 'Milkshake Coklat',
                'price' => 20000,
                'category' => 'minuman',
                'description' => 'Susu coklat blend dengan es krim.',
                'is_available' => true,
            ],
            [
                'name' => 'Lemon Tea',
                'price' => 10000,
                'category' => 'minuman',
                'description' => 'Teh dengan perasan lemon asli.',
                'is_available' => true,
            ],
        ];

        foreach ($menus as $menu) {
            // Kita set image null dulu, nanti admin bisa upload foto asli
            $menu['image'] = null; 
            Menu::create($menu);
        }
    }
}