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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique(); // No Transaksi (TP2025...)

            // Snapshot Alamat (Penting! Disimpan teks-nya, bukan ID-nya)
            // Supaya kalau user ubah alamat di profil, data history pesanan gak berubah.
            $table->string('recipient_name');
            $table->string('phone_number');
            $table->text('address_full'); // Jalan, RT/RW, Kelurahan, Kecamatan
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');

            // Info Pengiriman
            $table->string('courier'); // JNE
            $table->string('service'); // REG
            $table->integer('shipping_cost');
            $table->integer('total_weight');

            // Info Pembayaran
            $table->integer('subtotal');
            $table->integer('grand_total');
            $table->string('status')->default('pending'); // pending, paid, shipped, completed, cancelled
            $table->string('snap_token')->nullable(); // Untuk Midtrans

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
