<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'title' => 'Besi Bekas Konstruksi',
                'category' => 'besi-logam',
                'price_label' => 'Hubungi kami',
                'is_featured' => true,
                'description' => 'Besi beton, WF, UNP, dan siku bekas hasil bongkaran gedung maupun renovasi. Kami terima dalam jumlah banyak maupun satuan, timbang di tempat.',
            ],
            [
                'title' => 'Plat Baja Bekas',
                'category' => 'besi-logam',
                'price_label' => 'Per kg',
                'is_featured' => true,
                'description' => 'Plat baja bekas berbagai tebal, cocok untuk las-lasan, dasar mesin, dan kebutuhan bengkel.',
            ],
            [
                'title' => 'Pipa & Tube Baja Bekas',
                'category' => 'besi-logam',
                'price_label' => 'Per kg',
                'is_featured' => false,
                'description' => 'Pipa hitam, pipa galvanis, dan tube bekas berbagai diameter.',
            ],
            [
                'title' => 'Tembaga Kabel Bekas',
                'category' => 'besi-logam',
                'price_label' => 'Hubungi kami',
                'is_featured' => true,
                'description' => 'Kabel tembaga rumah tangga dan industri, trafo, dan gulungan tembaga. Harga terbaik untuk partai besar.',
            ],
            [
                'title' => 'Kuningan Bekas',
                'category' => 'besi-logam',
                'price_label' => 'Per kg',
                'is_featured' => false,
                'description' => 'Kran kuningan, ornamen, fitting, dan potongan kuningan lainnya.',
            ],
            [
                'title' => 'Profil & Kaleng Alumunium',
                'category' => 'besi-logam',
                'price_label' => 'Per kg',
                'is_featured' => false,
                'description' => 'Profil alumunium bekas kusen, rangka, velg, serta kaleng alumunium bersih.',
            ],
            [
                'title' => 'Mesin & Peralatan Bekas',
                'category' => 'barang-bekas',
                'price_label' => 'Nego',
                'is_featured' => false,
                'description' => 'Mesin industri, elektronik, dan peralatan bekas layak pakai maupun untuk rongsok.',
            ],
            [
                'title' => 'Furnitur & Perlengkapan Bekas',
                'category' => 'barang-bekas',
                'price_label' => 'Nego',
                'is_featured' => false,
                'description' => 'Meja, kursi, lemari, dan perlengkapan kantor/rumah bekas yang masih layak.',
            ],
            [
                'title' => 'Jasa Angkut Barang Bekas',
                'category' => 'jasa',
                'price_label' => 'Hubungi kami',
                'is_featured' => false,
                'description' => 'Jasa angkut dan bongkar muat barang bekas, rongsok, serta sisa renovasi. Armada tersedia untuk area Jabo-Bekasi.',
            ],
            [
                'title' => 'Jasa Pastikan Beli (Langganan Pabrik)',
                'category' => 'jasa',
                'price_label' => 'Kontrak',
                'is_featured' => false,
                'description' => 'Kerja sama pengangkutan rutin scrap logam dari pabrik dan workshop dengan harga pasti.',
            ],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['slug' => Str::slug($product['title'])],
                $product + ['is_active' => true],
            );
        }
    }
}
