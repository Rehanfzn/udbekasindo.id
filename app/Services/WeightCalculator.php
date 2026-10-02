<?php

namespace App\Services;

use App\Models\Material;
use App\Models\StructuralProfile;
use Illuminate\Validation\ValidationException;

class WeightCalculator
{
    /**
     * Hitung volume, berat, dan estimasi harga dari dimensi material.
     *
     * @param  array<string, mixed>  $input  dimensi dalam mm (atau meter untuk profil)
     * @return array{
     *     shape: string,
     *     quantity: int,
     *     unit_volume_m3: float|null,
     *     volume_m3: float|null,
     *     weight_kg: float,
     *     price: float,
     *     material: Material,
     *     profile: StructuralProfile|null
     * }
     *
     * @throws ValidationException
     */
    public function calculate(
        string $shape,
        array $input,
        Material $material,
        int $quantity = 1,
        ?StructuralProfile $profile = null,
    ): array {
        $quantity = max(1, $quantity);

        if ($shape === 'profil') {
            return $this->fromProfile($input, $material, $profile, $quantity);
        }

        $unitVolume = match ($shape) {
            'plat' => $this->volumePlate($input),
            'batang', 'kawat' => $this->volumeRound($input),
            'pipa' => $this->volumePipe($input),
            'siku' => $this->volumeAngle($input),
            default => throw ValidationException::withMessages([
                'shape' => 'Bentuk material tidak dikenal.',
            ]),
        };

        $weightKg = $unitVolume * $material->density_kg_m3 * $quantity;

        return [
            'shape' => $shape,
            'quantity' => $quantity,
            'unit_volume_m3' => $unitVolume,
            'volume_m3' => $unitVolume * $quantity,
            'weight_kg' => $weightKg,
            'price' => $weightKg * $material->price_per_kg,
            'material' => $material,
            'profile' => null,
        ];
    }

    /** @param array<string, mixed> $input */
    private function fromProfile(array $input, Material $material, ?StructuralProfile $profile, int $quantity): array
    {
        if (! $profile) {
            throw ValidationException::withMessages([
                'profile_id' => 'Pilih ukuran profil baja terlebih dahulu.',
            ]);
        }

        $lengthM = $this->positive($input, 'panjang', 'Panjang harus lebih dari 0 (meter).');
        $unitWeight = $profile->weight_per_m * $lengthM;
        $weightKg = $unitWeight * $quantity;

        return [
            'shape' => 'profil',
            'quantity' => $quantity,
            'unit_volume_m3' => null,
            'volume_m3' => null,
            'weight_kg' => $weightKg,
            'price' => $weightKg * $material->price_per_kg,
            'material' => $material,
            'profile' => $profile,
        ];
    }

    /** @param array<string, mixed> $input */
    private function volumePlate(array $input): float
    {
        $p = $this->positive($input, 'panjang');
        $l = $this->positive($input, 'lebar');
        $t = $this->positive($input, 'tebal');

        return ($p * $l * $t) / 1_000_000_000;
    }

    /** @param array<string, mixed> $input */
    private function volumeRound(array $input): float
    {
        $d = $this->positive($input, 'diameter');
        $l = $this->positive($input, 'panjang');

        return (M_PI / 4 * $d * $d * $l) / 1_000_000_000;
    }

    /** @param array<string, mixed> $input */
    private function volumePipe(array $input): float
    {
        $outer = $this->positive($input, 'diameter');
        $t = $this->positive($input, 'tebal');
        $l = $this->positive($input, 'panjang');

        if ($t * 2 >= $outer) {
            throw ValidationException::withMessages([
                'tebal' => 'Tebal dinding tidak boleh melebihi setengah diameter luar.',
            ]);
        }

        $inner = $outer - 2 * $t;

        return (M_PI / 4 * ($outer * $outer - $inner * $inner) * $l) / 1_000_000_000;
    }

    /** @param array<string, mixed> $input */
    private function volumeAngle(array $input): float
    {
        $a = $this->positive($input, 'sisi_a');
        $b = $this->positive($input, 'sisi_b');
        $t = $this->positive($input, 'tebal');
        $l = $this->positive($input, 'panjang');

        if ($t >= $a || $t >= $b) {
            throw ValidationException::withMessages([
                'tebal' => 'Tebal harus lebih kecil dari kedua sisi.',
            ]);
        }

        $areaMm2 = $a * $t + ($b - $t) * $t;

        return ($areaMm2 * $l) / 1_000_000_000;
    }

    /** @param array<string, mixed> $input */
    private function positive(array $input, string $key, ?string $message = null): float
    {
        $value = (float) ($input[$key] ?? 0);

        if ($value <= 0) {
            throw ValidationException::withMessages([
                $key => $message ?? ucfirst(str_replace('_', ' ', $key)).' harus lebih dari 0.',
            ]);
        }

        return $value;
    }
}
