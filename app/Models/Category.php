<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Kita gunakan guarded id agar semua kolom lain bisa diisi (mass assignment)
    protected $guarded = ['id'];
    protected $fillable = ['name', 'slug', 'image_path'];

    // Relasi: Satu kategori bisa punya banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
