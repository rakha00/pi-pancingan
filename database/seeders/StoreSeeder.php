<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Joran (Rods)' => [
                ['name' => 'Shimano Cruzar 180cm', 'price' => 250000, 'stock' => 50, 'desc' => 'Joran Shimano berbahan fiber solid, sangat lentur dan kuat.'],
                ['name' => 'Daiwa Crossfire', 'price' => 450000, 'stock' => 30, 'desc' => 'Joran modern dengan material graphite berkualitas dari Daiwa.'],
                ['name' => 'Maguro Extreme 150cm', 'price' => 300000, 'stock' => 40, 'desc' => 'Joran Maguro yang cocok untuk galatama dan harian.'],
                ['name' => 'Kenzi Torzite Ultralight', 'price' => 350000, 'stock' => 25, 'desc' => 'Joran ultralight dengan cincin guide yang sangat ringan dan sensitif.'],
            ],
            'Reel (Gulungan)' => [
                ['name' => 'Shimano Stella SW', 'price' => 15000000, 'stock' => 5, 'desc' => 'Reel premium Shimano dengan teknologi kedap air dan bearing halus.'],
                ['name' => 'Ryobi Ultra Power 1000', 'price' => 450000, 'stock' => 25, 'desc' => 'Reel ultralight murah dan tangguh dari Ryobi.'],
                ['name' => 'Daido Manta 3000', 'price' => 150000, 'stock' => 60, 'desc' => 'Reel murah berkualitas dengan bearing yang sudah cukup mumpuni.'],
                ['name' => 'Penn Spinfisher VI 4500', 'price' => 2100000, 'stock' => 15, 'desc' => 'Reel khusus jagoan laut (saltwater) yang tahan karat dengan drag besar.'],
            ],
            'Senar (Lines)' => [
                ['name' => 'Senar PE X8 Duraking 100m', 'price' => 85000, 'stock' => 100, 'desc' => 'Senar jalinan 8 lilitan, sangat kuat menahan beban ikan besar.'],
                ['name' => 'Fluorocarbon Leader Seahawk 50m', 'price' => 120000, 'stock' => 80, 'desc' => 'Senar leader fluo transparan di dalam air, tidak mudah putus atau tergores gigi ikan.'],
                ['name' => 'Nylon Monofilament Blood 0.25mm', 'price' => 35000, 'stock' => 200, 'desc' => 'Senar nylon standar, elastis dan cocok untuk memancing santai di kolam atau sungai.'],
            ],
            'Kail & Aksesoris' => [
                ['name' => 'Kail Carbon Daido Chinu No. 5', 'price' => 15000, 'stock' => 300, 'desc' => 'Satu bungkus kail carbon ukuran 5, ujung tajam dan kokoh.'],
                ['name' => 'Treble Hook Mustad No. 3', 'price' => 45000, 'stock' => 100, 'desc' => 'Mata kail mematikan cabang 3 untuk dipasang pada umpan mainan (lure).'],
                ['name' => 'Tang Pancing (Fishing Pliers)', 'price' => 50000, 'stock' => 50, 'desc' => 'Tang lipat multi-fungsi untuk melepas kail, memotong senar PE, dan membuka ring split.'],
            ],
            'Umpan (Baits & Lures)' => [
                ['name' => 'Lure Minnow Sinking 10g', 'price' => 35000, 'stock' => 120, 'desc' => 'Umpan tiruan sinking bentuk ikan kecil dengan action berenang alami.'],
                ['name' => 'Soft Frog Gejrot 5cm', 'price' => 25000, 'stock' => 80, 'desc' => 'Umpan katak karet anti nyangkut, sangat jitu untuk ikan gabus (snakehead) dan toman.'],
                ['name' => 'Essen Oplosan Nangka Susu', 'price' => 60000, 'stock' => 70, 'desc' => 'Essen aromatik wangi nangka dicampur susu murni, khusus untuk ikan mas ukuran babon.'],
                ['name' => 'Umpan Pelet Jitu (1 Sachet)', 'price' => 5000, 'stock' => 500, 'desc' => 'Umpan praktis serbuk yang hanya perlu diseduh air panas. Cocok untuk semua ikan air tawar.'],
            ],
            'Perlengkapan Lainnya' => [
                ['name' => 'Tas Pancing Ransel Shimano 120cm', 'price' => 120000, 'stock' => 40, 'desc' => 'Tas kaku pelindung tebal yang bisa memuat hingga 3 set joran beserta berbagai macam alat pancing.'],
                ['name' => 'Jaring Keramba / Koja Ikan 2 Meter', 'price' => 30000, 'stock' => 60, 'desc' => 'Wadah jaring untuk menaruh dan menyimpan ikan hasil tangkapan agar tetap hidup di dalam air.'],
                ['name' => 'Pelampung Starlet Fosfor Pancing (Isi 5)', 'price' => 10000, 'stock' => 200, 'desc' => 'Batang fosfor untuk ujung pelampung agar bisa memancing asik di malam hari.'],
            ],
        ];

        foreach ($categories as $categoryName => $products) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
            ]);

            foreach ($products as $prod) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $prod['name'],
                    'slug' => Str::slug($prod['name']),
                    'description' => $prod['desc'],
                    'price' => $prod['price'],
                    'stock' => $prod['stock'],
                ]);
            }
        }
    }
}
