🍽️ Leman Barokah - Point of Sale & Digital Ordering System

Leman Barokah adalah sebuah platform manajemen restoran berbasis web yang dibangun dengan framework Laravel. Sistem ini mengintegrasikan proses pemesanan digital bagi pelanggan (Customer) dengan manajemen operasional dan laporan keuangan bagi pemilik usaha (Admin) secara real-time.

📑 Daftar Isi

Panduan Instalasi

Akun Akses Default

Tech Stack

Fitur Utama

Relasi Database

Peta Kode & File Penting

Troubleshooting

🛠️ Panduan Instalasi (Langkah Menjalankan Projek)

Ikuti urutan langkah di bawah ini untuk menjalankan projek di lingkungan lokal (localhost):

1. Persiapan Environment

Pastikan laptop/komputer kamu sudah terinstall:

PHP >= 8.1

Composer

Node.js & NPM

Server Database (MySQL/MariaDB via Laragon atau XAMPP)

2. Instalasi Dependency

Buka terminal di dalam folder projek, kemudian jalankan:

# Menginstal library PHP (Laravel)
composer install

# Menginstal library Frontend (Tailwind CSS & JavaScript)
npm install && npm run build


3. Konfigurasi Database (.env)

Salin file .env.example menjadi .env.

Buka file .env dan sesuaikan nama database kamu:

DB_DATABASE=db_leman_barokah
DB_USERNAME=root
DB_PASSWORD=


Generate Key aplikasi:

php artisan key:generate


4. Aktivasi File Storage (PENTING)

Agar gambar menu makanan dan foto bukti transfer muncul di browser, jalankan:

php artisan storage:link


5. Migrasi & Seeding Data

Perintah ini akan membuat tabel otomatis dan mengisi database dengan 30+ menu dan 150+ transaksi dummy:

php artisan migrate:fresh --seed


6. Menjalankan Server

php artisan serve


Akses melalui browser di: http://127.0.0.1:8000

👥 Akun Akses Default

Admin: admin@gmail.com | Password: password

Customer: customer@gmail.com | Password: password

💻 Tech Stack

Framework: Laravel 11 (PHP)

Frontend UI: Tailwind CSS & Blade Templating

Interaktivitas: Alpine.js & jQuery (sistem Keranjang AJAX)

Database: MySQL / MariaDB

Iconography: Lucide Icons & FontAwesome (via SVG)

🌟 Fitur Utama Sistem

Sisi Pelanggan (Customer)

Katalog Menu Digital: Filter kategori dan pencarian dinamis.

AJAX Shopping Cart: Tambah, kurang, dan hapus item keranjang tanpa reload.

Checkout Fleksibel: Pilihan Dine In (dengan nomor meja) atau Pickup.

Upload Bukti Pembayaran: Mendukung unggahan gambar untuk transfer bank.

Track Order Aktif: Pelacakan status pesanan real-time (Pending, Processing, Ready).

Riwayat Belanja: Melihat log transaksi masa lalu dengan pagination.

Sisi Pengelola (Admin)

Dashboard Statistik: Pantauan omset total dan jumlah transaksi harian.

Manajemen Menu (CRUD): Kelola daftar menu lengkap dengan fitur unggah foto masakan.

Live Order Monitor: Kelola pesanan masuk dan ubah status dapur.

Validasi Pembayaran: Pengecekan bukti transfer visual untuk menerbitkan nomor antrian.

Laporan Keuangan: Laporan pendapatan yang dapat difilter tanggal dan diprint.

🗄️ Relasi Database

Users (1) -> Orders (N): Satu pelanggan bisa memiliki banyak riwayat pesanan.

Orders (1) -> OrderItems (N): Satu transaksi pesanan terdiri dari banyak item menu.

Menus (1) -> OrderItems (N): Satu menu bisa dipesan dalam banyak transaksi berbeda.

📂 Peta Kode & File Penting (Seluruh File Utama)

1. Konfigurasi & Route

routes/web.php: Mengatur semua jalur URL aplikasi (Admin & Customer).

.env: File pengaturan database dan koneksi server.

2. Database (Models, Migrations, Seeders)

app/Models/User.php: Mengatur data pengguna dan hak akses (Role).

app/Models/Menu.php: Mengatur data makanan, harga, dan kategori.

app/Models/Order.php: Menyimpan transaksi utama (Status, Pembayaran, Tipe Order).

app/Models/OrderItem.php: Menyimpan detail item yang dibeli per transaksi.

database/seeders/MenuSeeder.php: Mengisi data menu otomatis dengan download gambar.

database/seeders/DummyOrderSeeder.php: Mengisi 150+ data transaksi untuk pengujian.

3. Logic (Controllers)

app/Http/Controllers/OrderController.php: Mengatur alur belanja customer (Cart, Checkout, Tracking).

app/Http/Controllers/Admin/AdminOrderController.php: Mengatur proses pesanan masuk dan antrian dapur.

app/Http/Controllers/MenuController.php: Mengatur CRUD menu oleh Admin.

4. Antarmuka Pelanggan (Customer Views)

resources/views/customer/dashboard.blade.php: Halaman katalog menu & pencarian.

resources/views/customer/cart.blade.php: Halaman keranjang belanja dengan sistem AJAX.

resources/views/customer/checkout.blade.php: Form pemilihan tipe order & upload bukti transfer.

resources/views/customer/orders/index.blade.php: Halaman riwayat belanja (History).

resources/views/customer/orders/active.blade.php: Halaman pelacakan pesanan yang sedang berjalan.

5. Antarmuka Admin (Admin Views)

resources/views/admin/dashboard.blade.php: Dashboard statistik omset harian.

resources/views/admin/menus/index.blade.php: Daftar manajemen menu makanan.

resources/views/admin/orders/index.blade.php: Monitor pesanan masuk secara real-time.

resources/views/admin/orders/show.blade.php: Detail validasi bukti bayar & kontrol status dapur.

resources/views/admin/reports/index.blade.php: Halaman laporan keuangan & fitur cetak (print).

6. Layouts & Global Components

resources/views/layouts/app.blade.php: Layout induk aplikasi.

resources/views/layouts/navigation.blade.php: Navigasi bar dengan notifikasi indikator "Red Dot".

🛠️ Troubleshooting (Penyelesaian Masalah)

Gambar Tidak Muncul: Jalankan perintah php artisan storage:link.

Bukti Transfer NULL: Pastikan 'payment_proof' ada di variabel $fillable pada Model Order.php.

Error Mass Assignment: Gunakan metode $order->save() manual di controller untuk memastikan data masuk.

Leman Barokah — Digitalisasi Rasa, Modernisasi Usaha. 🚀