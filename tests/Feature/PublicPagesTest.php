<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Setting::flush();
        parent::tearDown();
    }

    public function test_home_page_loads(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('UD Bekas Indo')
            ->assertSee('Kalkulator');
    }

    public function test_about_page_loads(): void
    {
        $this->get('/tentang')->assertOk()->assertSee('Tentang Kami');
    }

    public function test_catalog_page_loads_and_search_works(): void
    {
        Product::create([
            'title' => 'Tembaga Kabel Bekas',
            'slug' => 'tembaga-kabel-bekas',
            'category' => 'besi-logam',
            'description' => 'Kabel tembaga',
            'price_label' => 'Hubungi kami',
            'is_active' => true,
        ]);

        $this->get('/katalog')
            ->assertOk()
            ->assertSee('Tembaga Kabel Bekas');

        $this->get('/katalog?q=tembaga')
            ->assertOk()
            ->assertSee('Tembaga Kabel Bekas');

        $this->get('/katalog?q=tidak-ada')
            ->assertOk()
            ->assertSee('Produk tidak ditemukan');
    }

    public function test_product_detail_page_and_404(): void
    {
        Product::create([
            'title' => 'Plat Baja Bekas',
            'slug' => 'plat-baja-bekas',
            'category' => 'besi-logam',
            'description' => 'Plat baja berbagai tebal',
            'is_active' => true,
        ]);

        $this->get('/katalog/plat-baja-bekas')
            ->assertOk()
            ->assertSee('Plat Baja Bekas');

        $this->get('/katalog/tidak-ada')->assertNotFound();
    }

    public function test_calculator_page_loads(): void
    {
        $this->get('/kalkulator')
            ->assertOk()
            ->assertSee('Hitung Berat')
            ->assertSee('Bentuk Material');
    }

    public function test_whatsapp_popup_shows_when_configured(): void
    {
        Setting::set('whatsapp', '6281234567890');

        $this->get('/')
            ->assertOk()
            ->assertSee('data-wa-popup', false)
            ->assertSee('https://wa.me/6281234567890', false)
            ->assertSee('Chat Sekarang');
    }

    public function test_whatsapp_popup_hidden_when_not_configured(): void
    {
        Setting::flush();

        $this->get('/')
            ->assertOk()
            ->assertDontSee('data-wa-popup', false);
    }
}
