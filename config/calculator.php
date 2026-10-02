<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Definisi Bentuk untuk Kalkulator Berat & Harga
    |--------------------------------------------------------------------------
    | field key dipakai langsung di form, validasi, dan WeightCalculator.
    | unit: mm kecuali profil (meter, karena berat diambil dari tabel kg/m).
    */

    'shapes' => [

        'plat' => [
            'label' => 'Plat / Sheet',
            'formula' => 'V = Panjang × Lebar × Tebal',
            'description' => 'Pelat baja, aluminium, tembaga, dll.',
            'fields' => [
                ['key' => 'panjang', 'label' => 'Panjang', 'unit' => 'mm'],
                ['key' => 'lebar', 'label' => 'Lebar', 'unit' => 'mm'],
                ['key' => 'tebal', 'label' => 'Tebal', 'unit' => 'mm'],
            ],
            'uses_profile' => false,
        ],

        'batang' => [
            'label' => 'Batang Bulat',
            'formula' => 'V = π/4 × Diameter² × Panjang',
            'description' => 'Round bar, as, pipa solid.',
            'fields' => [
                ['key' => 'diameter', 'label' => 'Diameter', 'unit' => 'mm'],
                ['key' => 'panjang', 'label' => 'Panjang', 'unit' => 'mm'],
            ],
            'uses_profile' => false,
        ],

        'pipa' => [
            'label' => 'Pipa / Tube',
            'formula' => 'V = π/4 × (D² − (D − 2T)²) × Panjang',
            'description' => 'Pipa hollow / pipa schedule 40.',
            'fields' => [
                ['key' => 'diameter', 'label' => 'Diameter Luar', 'unit' => 'mm'],
                ['key' => 'tebal', 'label' => 'Tebal Dinding', 'unit' => 'mm'],
                ['key' => 'panjang', 'label' => 'Panjang', 'unit' => 'mm'],
            ],
            'uses_profile' => false,
        ],

        'siku' => [
            'label' => 'Besi Siku',
            'formula' => 'V = (A×T + (B−T)×T) × Panjang',
            'description' => 'Angle bar dengan dua sisi bebas (A × B).',
            'fields' => [
                ['key' => 'sisi_a', 'label' => 'Sisi A', 'unit' => 'mm'],
                ['key' => 'sisi_b', 'label' => 'Sisi B', 'unit' => 'mm'],
                ['key' => 'tebal', 'label' => 'Tebal', 'unit' => 'mm'],
                ['key' => 'panjang', 'label' => 'Panjang', 'unit' => 'mm'],
            ],
            'uses_profile' => false,
        ],

        'kawat' => [
            'label' => 'Kawat / Koil',
            'formula' => 'V = π/4 × Diameter² × Panjang Total',
            'description' => 'Kawat tembaga, kawat baja, dll.',
            'fields' => [
                ['key' => 'diameter', 'label' => 'Diameter Kawat', 'unit' => 'mm'],
                ['key' => 'panjang', 'label' => 'Panjang Total', 'unit' => 'mm'],
            ],
            'uses_profile' => false,
        ],

        'profil' => [
            'label' => 'Profil Baja (IWF / UNP)',
            'formula' => 'Berat = kg/m × Panjang',
            'description' => 'Menggunakan tabel berat per meter standar.',
            'fields' => [
                ['key' => 'panjang', 'label' => 'Panjang', 'unit' => 'm'],
            ],
            'uses_profile' => true,
        ],

    ],

];
