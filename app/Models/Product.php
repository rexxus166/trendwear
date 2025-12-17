<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'options' => 'array',
        'variants_data' => 'array',
        'price' => 'double', // Saya tambahkan ini agar tipe data price konsisten jadi angka
    ];

    /**
     * ACCESSOR: Manipulasi Harga Otomatis
     * Fungsi ini jalan otomatis saat kamu memanggil $product->price atau kirim JSON ke API.
     */
    public function getPriceAttribute($value)
    {
        // Skenario 1: Jika harga dasar di database TIDAK 0, pakai harga itu.
        if ($value > 0) {
            return $value;
        }

        // Skenario 2: Jika harga dasar 0, kita cari harga termurah dari varian.
        // Karena di $casts sudah didefinisikan 'array', kita bisa langsung akses sebagai array.
        if (!empty($this->variants_data) && is_array($this->variants_data)) {

            // Ambil semua value dari key 'price' di dalam JSON variants_data
            // Contoh data: [{"price": "80000"}, {"price": "84000"}] -> Jadi [80000, 84000]
            $prices = array_column($this->variants_data, 'price');

            // Jika ditemukan daftar harga
            if (!empty($prices)) {
                // Return harga terendah (Min) sebagai harga "Mulai dari"
                return min($prices);
            }
        }

        // Skenario 3: Kalau benar-benar tidak ada harga sama sekali, return 0
        return 0;
    }

    // ==========================================
    // RELASI (TIDAK ADA PERUBAHAN)
    // ==========================================

    // Relasi: Produk milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Produk bisa punya banyak gambar
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
