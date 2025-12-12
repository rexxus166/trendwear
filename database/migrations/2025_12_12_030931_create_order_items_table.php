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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained(); // Relasi ke produk

            $table->string('product_name'); // Simpan nama saat beli (jaga-jaga produk dihapus/ubah nama)
            $table->string('variant_info')->nullable(); // Contoh: "Size: L, Color: Red"
            $table->integer('quantity');
            $table->integer('price'); // Harga satuan saat beli
            $table->integer('subtotal'); // qty * price

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
