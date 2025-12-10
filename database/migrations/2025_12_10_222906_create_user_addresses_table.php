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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Informasi Penerima
            $table->string('recipient_name'); // Nama Penerima (bisa beda sama nama akun)
            $table->string('phone_number');   // No HP Penerima

            // Informasi Alamat
            $table->string('address_line1');  // Jalan, No Rumah, RT/RW
            $table->string('address_line2')->nullable(); // Patokan / Detail tambahan
            $table->string('province');       // Provinsi
            $table->string('city');           // Kota/Kabupaten
            $table->string('district');       // Kecamatan
            $table->string('village');        // Desa
            $table->string('postal_code');    // Kode Pos

            // Fitur Khusus
            $table->string('label')->default('Rumah'); // Tag: Rumah, Kantor, Kost
            $table->boolean('is_primary')->default(false); // Alamat Utama?

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
