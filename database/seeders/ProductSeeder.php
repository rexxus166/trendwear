<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Categories
        $streetwear = Category::create(['name' => 'Streetwear', 'slug' => 'streetwear']);
        $casual = Category::create(['name' => 'Casual', 'slug' => 'casual']);
        $accessories = Category::create(['name' => 'Accessories', 'slug' => 'accessories']);

        // 2. Create Products
        // Product 1
        Product::create([
            'category_id' => $streetwear->id,
            'name' => 'Oversized Graphic Tee "Urban Soul"',
            'slug' => 'oversized-graphic-tee-urban-soul',
            'price' => 185000,
            'description' => 'Kaos oversized dengan bahan katun combed 24s premium. Sablon plastisol tahan lama dengan desain urban yang edgy. Cocok untuk daily outfit.',
            'stock' => 50,
            'weight' => 250,
            'sku' => 'TS-URB-001',
            'status' => 'active',
            'sizes' => ['S', 'M', 'L', 'XL'],
            'colors' => ['Hitam', 'Putih', 'Sage Green'],
            'options' => [],
            'variants_data' => [
                ['price' => 185000, 'stock' => 50]
            ]
        ]);

        // Product 2
        Product::create([
            'category_id' => $casual->id,
            'name' => 'Chino Pants Slim Fit "Daily Grind"',
            'slug' => 'chino-pants-slim-fit-daily-grind',
            'price' => 299000,
            'description' => 'Celana chino potongan slim fit yang stretch dan nyaman. Menggunakan bahan twill scotch yang lembut.',
            'stock' => 30,
            'weight' => 500,
            'sku' => 'PN-CHI-002',
            'status' => 'active',
            'sizes' => ['28', '30', '32', '34'],
            'colors' => ['Khaki', 'Navy', 'Grey'],
            'options' => [],
            'variants_data' => [
                ['price' => 299000, 'stock' => 30]
            ]
        ]);

        // Product 3
        Product::create([
            'category_id' => $streetwear->id,
            'name' => 'Varsity Jacket "College Dropout"',
            'slug' => 'varsity-jacket-college-dropout',
            'price' => 450000,
            'description' => 'Jaket varsity klasik dengan kombinasi bahan fleece dan kulit sintetis pada lengan. Full bordir towel yang premium.',
            'stock' => 15,
            'weight' => 800,
            'sku' => 'JK-VAR-003',
            'status' => 'active',
            'sizes' => ['M', 'L', 'XL'],
            'colors' => ['Hitam/Putih', 'Navy/Cream'],
            'options' => [],
            'variants_data' => [
                ['price' => 450000, 'stock' => 15]
            ]
        ]);

        // Product 4
        Product::create([
            'category_id' => $accessories->id,
            'name' => 'Bucket Hat Reversible',
            'slug' => 'bucket-hat-reversible',
            'price' => 89000,
            'description' => 'Topi bucket yang bisa dibolak-balik (2 in 1). Satu sisi polos, sisi lain motif abstrak.',
            'stock' => 100,
            'weight' => 100,
            'sku' => 'AC-HAT-004',
            'status' => 'active',
            'sizes' => ['All Size'],
            'colors' => ['Hitam/Corak'],
            'options' => [],
            'variants_data' => [
                ['price' => 89000, 'stock' => 100]
            ]
        ]);
    }
}
