<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            [
                'name' => 'Besi / Baja Bekas',
                'category' => 'logam-ferro',
                'density_kg_m3' => 7850,
                'price_per_kg' => 7000,
                'description' => 'Besi dan baja bekas konstruksi, mesin, dan peralatan.',
            ],
            [
                'name' => 'Besi Beton Bekas',
                'category' => 'logam-ferro',
                'density_kg_m3' => 7850,
                'price_per_kg' => 6500,
                'description' => 'Besi beton / ulir bekas bongkaran.',
            ],
            [
                'name' => 'Stainless Steel',
                'category' => 'logam-ferro',
                'density_kg_m3' => 7900,
                'price_per_kg' => 12000,
                'description' => 'Scrap stainless kitchen equipment, pipa, dan plat.',
            ],
            [
                'name' => 'Tembaga',
                'category' => 'logam-non-ferro',
                'density_kg_m3' => 8960,
                'price_per_kg' => 95000,
                'description' => 'Tembaga murni: kabel, pipa, rangka motor, trafo.',
            ],
            [
                'name' => 'Kuningan',
                'category' => 'logam-non-ferro',
                'density_kg_m3' => 8500,
                'price_per_kg' => 65000,
                'description' => 'Kuningan bekas: kran, ornamen, fitting.',
            ],
            [
                'name' => 'Alumunium',
                'category' => 'logam-non-ferro',
                'density_kg_m3' => 2700,
                'price_per_kg' => 22000,
                'description' => 'Profil, velg, kaleng, dan casing alumunium.',
            ],
            [
                'name' => 'Timah Hitam (Plumbum)',
                'category' => 'logam-non-ferro',
                'density_kg_m3' => 11340,
                'price_per_kg' => 18000,
                'description' => 'Aki bekas, timah solder, penimbang.',
            ],
            [
                'name' => 'Seng',
                'category' => 'logam-non-ferro',
                'density_kg_m3' => 7140,
                'price_per_kg' => 5000,
                'description' => 'Seng bekas atap, kaleng seng.',
            ],
            [
                'name' => 'Plastik Keras',
                'category' => 'non-logam',
                'density_kg_m3' => 1400,
                'price_per_kg' => 3500,
                'description' => 'Plastik keras PVC/ABS bekas peralatan.',
            ],
        ];

        foreach ($materials as $material) {
            Material::query()->updateOrCreate(
                ['slug' => Str::slug($material['name'])],
                $material + ['is_active' => true],
            );
        }
    }
}
