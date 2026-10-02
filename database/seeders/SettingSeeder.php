<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'company_name' => 'UD Bekas Indo',
            'tagline' => 'Jual Beli Barang Bekas, Besi, Tembaga & Logam Lainnya',
            'phone' => '0812-0000-0000',
            'whatsapp' => '6281200000000',
            'email' => 'info@udbekasindo.id',
            'address' => 'Jl. Industri Raya, Bekasi, Jawa Barat',
            'working_hours' => 'Senin – Sabtu, 08.00 – 17.00 WIB',
            'about' => "UD Bekas Indo adalah perusahaan yang bergerak di bidang jual beli barang bekas dan limbah logam. Kami menerima berbagai jenis scrap besi, tembaga, kuningan, alumunium, stainless, serta barang bekas lainnya dari rumah tangga, bengkel, maupun pabrik.\n\nDengan tim yang berpengalaman dan armada angkut sendiri, kami siap menjemput barang di lokasi Anda, menimbang di tempat, dan membayar secara transparan. Selain menjual kembali material terpilih, kami juga melayani jasa angkut barang bekas.",
            'footer_note' => '© UD Bekas Indo. Jual beli barang bekas & logam.',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
