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
    ];

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
}
