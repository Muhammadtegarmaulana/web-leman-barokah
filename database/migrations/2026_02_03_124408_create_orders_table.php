<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke Customer
            
            // Info Pemesanan
            $table->string('queue_number')->nullable(); // Diisi setelah lunas (Misal: A-01)
            $table->string('table_number')->nullable(); // Null jika Pickup
            $table->enum('order_type', ['dine_in', 'pickup']);
            
            // Info Pembayaran
            $table->enum('payment_method', ['cash', 'transfer']);
            $table->string('payment_proof')->nullable(); // Path gambar bukti TF
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            
            // Status Order
            // pending = baru pesan, processing = dimasak, ready = siap diambil, completed = selesai
            $table->enum('order_status', ['pending', 'processing', 'ready', 'completed'])->default('pending');
            
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
