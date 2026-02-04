<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DummyOrderSeeder extends Seeder
{
    public function run()
    {
        // 1. AMBIL SEMUA USER CUSTOMER
        $customers = User::where('role', 'customer')->get();

        // JAGA-JAGA: Jika tidak ada customer, buat satu
        if ($customers->isEmpty()) {
            $newCustomer = User::create([
                'name' => 'Rangga Customer',
                'email' => 'rangga@leman.com',
                'role' => 'customer',
                'password' => Hash::make('password'),
            ]);
            $customers = collect([$newCustomer]);
        }

        // 2. AMBIL DATA MENU
        $menus = Menu::all();

        if ($menus->isEmpty()) {
            $this->command->info('⚠️ Tidak ada data Menu. Jalankan MenuSeeder terlebih dahulu!');
            return;
        }

        // 3. GENERATE 150 TRANSAKSI DUMMY (Biar Ramai!)
        for ($i = 0; $i < 150; $i++) {
            
            // Pilih Customer Acak
            $randomCustomer = $customers->random();

            // Tentukan Tanggal Acak (0 s/d 60 hari yang lalu)
            // Jam operasional acak antara jam 9 pagi sampai jam 9 malam
            $date = Carbon::now()->subDays(rand(0, 60))->setTime(rand(9, 21), rand(0, 59));
            
            // Pilih 1 s/d 5 menu secara acak per transaksi
            $take = min(rand(1, 5), $menus->count()); 
            $randomMenus = $menus->random($take);
            
            $totalPrice = 0;
            $orderItemsData = [];

            // Hitung total harga & siapkan data item
            foreach($randomMenus as $menu) {
                $qty = rand(1, 4); // Qty per item 1-4 porsi
                $price = $menu->price * $qty;
                $totalPrice += $price;

                $orderItemsData[] = [
                    'menu_id' => $menu->id,
                    'quantity' => $qty,
                    'price' => $menu->price,
                ];
            }

            // Tentukan Status secara Acak
            // 80% Selesai (History), 15% Proses (Dapur), 5% Pending (Baru Masuk)
            $randStatus = rand(1, 100);
            
            if ($randStatus <= 80) {
                // SELESAI (Masuk Riwayat)
                $status = 'completed';
                $payStatus = 'paid';
                $queue = 'A-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            } elseif ($randStatus <= 95) {
                // SEDANG DIMASAK / SIAP (Masuk Pesanan Aktif)
                $status = rand(0,1) ? 'processing' : 'ready';
                $payStatus = 'paid';
                $queue = 'A-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            } else {
                // BARU PESAN (Belum Bayar)
                $status = 'pending';
                $payStatus = 'unpaid';
                $queue = null; // Belum dapat nomor antrian
            }

            // Buat Order di Database
            $order = Order::create([
                'user_id' => $randomCustomer->id,
                'order_type' => rand(0, 1) ? 'dine_in' : 'pickup',
                'table_number' => rand(1, 20),
                'payment_method' => rand(0, 1) ? 'cash' : 'transfer',
                'payment_status' => $payStatus, 
                'order_status' => $status, 
                'queue_number' => $queue,
                'total_price' => $totalPrice,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // Simpan Detail Item
            foreach($orderItemsData as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}