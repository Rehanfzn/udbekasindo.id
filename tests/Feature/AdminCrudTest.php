<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_admin_can_create_material(): void
    {
        $response = $this->actingAs($this->admin())->post(route('admin.materials.store'), [
            'name' => 'Tembaga Uji',
            'category' => 'logam-non-ferro',
            'density_kg_m3' => 8960,
            'price_per_kg' => 90000,
            'description' => 'Uji coba',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.materials.index'));

        $material = Material::query()->where('slug', 'tembaga-uji')->firstOrFail();

        $this->assertSame(8960.0, $material->density_kg_m3);
        $this->assertSame(90000.0, $material->price_per_kg);
        $this->assertTrue($material->is_active);
    }

    public function test_admin_can_update_material_price(): void
    {
        $material = Material::create([
            'name' => 'Besi Uji',
            'slug' => 'besi-uji',
            'category' => 'logam-ferro',
            'density_kg_m3' => 7850,
            'price_per_kg' => 7000,
            'is_active' => true,
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.materials.update', $material), [
                'name' => 'Besi Uji',
                'category' => 'logam-ferro',
                'density_kg_m3' => 7850,
                'price_per_kg' => 8500,
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.materials.index'));

        $this->assertSame(8500.0, $material->fresh()->price_per_kg);
    }

    public function test_admin_can_delete_material(): void
    {
        $material = Material::create([
            'name' => 'Seng Uji',
            'slug' => 'seng-uji',
            'category' => 'logam-non-ferro',
            'density_kg_m3' => 7140,
            'price_per_kg' => 5000,
            'is_active' => true,
        ]);

        $this->actingAs($this->admin())
            ->delete(route('admin.materials.destroy', $material))
            ->assertRedirect(route('admin.materials.index'));

        $this->assertDatabaseMissing('materials', ['id' => $material->id]);
    }

    public function test_material_validation_requires_numeric_price(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.materials.store'), [
                'name' => 'Tanpa Harga',
                'category' => 'logam-ferro',
                'density_kg_m3' => 7850,
                'price_per_kg' => 'abc',
            ])
            ->assertSessionHasErrors('price_per_kg');
    }

    public function test_admin_can_create_product_and_settings(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.products.store'), [
            'title' => 'Produk Uji Baru',
            'category' => 'barang-bekas',
            'description' => 'Deskripsi uji',
            'price_label' => 'Nego',
            'is_active' => '1',
            'is_featured' => '1',
        ])->assertRedirect(route('admin.products.index'));

        $product = Product::query()->where('slug', 'produk-uji-baru')->firstOrFail();
        $this->assertTrue($product->is_featured);
        $this->assertTrue($product->is_active);

        $this->actingAs($admin)->put(route('admin.settings.update'), [
            'company_name' => 'UD Bekas Indo Test',
            'tagline' => 'Tagline Baru',
            'whatsapp' => '628111111111',
            'phone' => '021-555',
            'email' => 'halo@uji.test',
            'address' => 'Jl. Uji',
            'working_hours' => 'Senin',
            'about' => 'Tentang uji',
            'footer_note' => 'Footer uji',
        ])->assertRedirect(route('admin.settings.edit'));

        $this->assertDatabaseHas('settings', ['key' => 'company_name', 'value' => 'UD Bekas Indo Test']);
        $this->assertSame('628111111111', Setting::get('whatsapp'));
    }

    public function test_admin_pages_render(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('admin.materials.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.materials.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.products.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.products.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.settings.edit'))->assertOk();
        $this->actingAs($admin)->get(route('admin.profiles.index'))->assertOk();
    }
}
