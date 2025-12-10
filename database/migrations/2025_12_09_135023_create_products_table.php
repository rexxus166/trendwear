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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();

            $table->decimal('price', 15, 2); // Harga dasar / Harga mulai dari

            $table->text('description')->nullable();
            $table->integer('stock')->default(0);

            // Kolom Varian
            $table->json('options')->nullable(); // Pilihan umum (opsional)
            $table->json('sizes')->nullable();   // List ukuran: ["S", "M"]
            $table->json('colors')->nullable();  // List warna: ["Merah", "Biru"]

            // KOLOM BARU: Menyimpan harga spesifik per varian
            $table->json('variants_data')->nullable();

            $table->string('sku')->unique();
            $table->enum('status', ['active', 'draft', 'out_of_stock'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
