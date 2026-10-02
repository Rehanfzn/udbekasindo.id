<?php

namespace Database\Seeders;

use App\Models\StructuralProfile;
use Illuminate\Database\Seeder;

class StructuralProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Nilai standar ≈ (kg/m), acuan umum SNI/DIN — dapat disesuaikan lewat database.
        $profiles = [
            ['type' => 'IWF', 'size' => 'IWF 100 x 100', 'weight_per_m' => 17.2],
            ['type' => 'IWF', 'size' => 'IWF 125 x 125', 'weight_per_m' => 23.8],
            ['type' => 'IWF', 'size' => 'IWF 150 x 150', 'weight_per_m' => 31.5],
            ['type' => 'IWF', 'size' => 'IWF 175 x 175', 'weight_per_m' => 40.4],
            ['type' => 'IWF', 'size' => 'IWF 200 x 100', 'weight_per_m' => 20.9],
            ['type' => 'IWF', 'size' => 'IWF 200 x 200', 'weight_per_m' => 49.9],
            ['type' => 'IWF', 'size' => 'IWF 250 x 125', 'weight_per_m' => 29.9],
            ['type' => 'IWF', 'size' => 'IWF 250 x 250', 'weight_per_m' => 72.4],
            ['type' => 'IWF', 'size' => 'IWF 300 x 150', 'weight_per_m' => 36.7],
            ['type' => 'IWF', 'size' => 'IWF 300 x 300', 'weight_per_m' => 94.0],
            ['type' => 'IWF', 'size' => 'IWF 350 x 175', 'weight_per_m' => 49.6],
            ['type' => 'IWF', 'size' => 'IWF 400 x 200', 'weight_per_m' => 66.0],
            ['type' => 'IWF', 'size' => 'IWF 500 x 200', 'weight_per_m' => 89.6],
            ['type' => 'IWF', 'size' => 'IWF 600 x 200', 'weight_per_m' => 106.0],
            ['type' => 'UNP', 'size' => 'UNP 50', 'weight_per_m' => 3.8],
            ['type' => 'UNP', 'size' => 'UNP 65', 'weight_per_m' => 5.9],
            ['type' => 'UNP', 'size' => 'UNP 80', 'weight_per_m' => 7.0],
            ['type' => 'UNP', 'size' => 'UNP 100', 'weight_per_m' => 8.6],
            ['type' => 'UNP', 'size' => 'UNP 120', 'weight_per_m' => 10.4],
            ['type' => 'UNP', 'size' => 'UNP 140', 'weight_per_m' => 12.6],
            ['type' => 'UNP', 'size' => 'UNP 160', 'weight_per_m' => 14.9],
            ['type' => 'UNP', 'size' => 'UNP 180', 'weight_per_m' => 17.8],
            ['type' => 'UNP', 'size' => 'UNP 200', 'weight_per_m' => 20.6],
            ['type' => 'UNP', 'size' => 'UNP 240', 'weight_per_m' => 27.1],
            ['type' => 'UNP', 'size' => 'UNP 280', 'weight_per_m' => 34.0],
            ['type' => 'UNP', 'size' => 'UNP 300', 'weight_per_m' => 38.1],
        ];

        foreach ($profiles as $profile) {
            StructuralProfile::query()->updateOrCreate(
                ['type' => $profile['type'], 'size' => $profile['size']],
                ['weight_per_m' => $profile['weight_per_m']],
            );
        }
    }
}
