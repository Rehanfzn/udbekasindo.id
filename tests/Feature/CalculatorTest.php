<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\StructuralProfile;
use App\Services\WeightCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CalculatorTest extends TestCase
{
    use RefreshDatabase;

    private function steel(): Material
    {
        return Material::create([
            'name' => 'Besi / Baja Bekas',
            'slug' => 'besi-baja-bekas',
            'category' => 'logam-ferro',
            'density_kg_m3' => 7850,
            'price_per_kg' => 7000,
            'is_active' => true,
        ]);
    }

    public function test_plate_volume_weight_and_price_are_calculated(): void
    {
        $material = $this->steel();

        $response = $this->post(route('calculator.calculate'), [
            'shape' => 'plat',
            'material_id' => $material->id,
            'jumlah' => 2,
            'panjang' => 1000,
            'lebar' => 500,
            'tebal' => 10,
        ]);

        $response->assertOk()->assertViewIs('calculator.index');

        $result = $response->viewData('result');

        $this->assertEqualsWithDelta(0.005, $result['unit_volume_m3'], 1e-9);
        $this->assertEqualsWithDelta(0.01, $result['volume_m3'], 1e-9);
        $this->assertEqualsWithDelta(78.5, $result['weight_kg'], 1e-6);
        $this->assertEqualsWithDelta(549500.0, $result['price'], 1e-6);
    }

    public function test_ajax_request_returns_rendered_result_html(): void
    {
        $material = $this->steel();

        $response = $this->post(route('calculator.calculate'), [
            'shape' => 'plat',
            'material_id' => $material->id,
            'jumlah' => 1,
            'panjang' => 1000,
            'lebar' => 500,
            'tebal' => 10,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
        ]);

        $response->assertOk()->assertJsonStructure(['html']);
        $this->assertStringContainsString('39,25', $response->json('html'));
        $this->assertStringContainsString('274.750', $response->json('html'));
    }

    public function test_missing_dimensions_are_rejected(): void
    {
        $material = $this->steel();

        $this->post(route('calculator.calculate'), [
            'shape' => 'plat',
            'material_id' => $material->id,
            'panjang' => 1000,
        ])->assertSessionHasErrors(['lebar', 'tebal']);
    }

    public function test_pipe_wall_thickness_must_be_valid(): void
    {
        $material = $this->steel();

        $this->post(route('calculator.calculate'), [
            'shape' => 'pipa',
            'material_id' => $material->id,
            'jumlah' => 1,
            'diameter' => 50,
            'tebal' => 30,
            'panjang' => 1000,
        ])->assertSessionHasErrors('tebal');
    }

    public function test_profile_shape_uses_weight_per_meter_table(): void
    {
        $material = $this->steel();
        $profile = StructuralProfile::create([
            'type' => 'IWF',
            'size' => 'IWF 200 x 200',
            'weight_per_m' => 49.9,
        ]);

        $response = $this->post(route('calculator.calculate'), [
            'shape' => 'profil',
            'material_id' => $material->id,
            'jumlah' => 2,
            'panjang' => 6,
            'profile_id' => $profile->id,
        ]);

        $response->assertOk();

        $result = $response->viewData('result');

        $this->assertEqualsWithDelta(49.9 * 6 * 2, $result['weight_kg'], 1e-6);
        $this->assertNull($result['volume_m3']);
    }

    public function test_service_calculates_pipe_volume(): void
    {
        $material = $this->steel();

        // D=50, t=2, L=1000mm → V = π/4 × (50² − 46²) × 1000 / 1e9
        $expected = (M_PI / 4 * (2500 - 2116) * 1000) / 1_000_000_000;

        $result = app(WeightCalculator::class)->calculate('pipa', [
            'diameter' => 50,
            'tebal' => 2,
            'panjang' => 1000,
        ], $material, 1);

        $this->assertEqualsWithDelta($expected, $result['unit_volume_m3'], 1e-12);
        $this->assertEqualsWithDelta($expected * 7850, $result['weight_kg'], 1e-9);
    }

    public function test_service_rejects_unknown_shape(): void
    {
        $this->expectException(ValidationException::class);

        app(WeightCalculator::class)->calculate('ganjil', [], $this->steel(), 1);
    }
}
