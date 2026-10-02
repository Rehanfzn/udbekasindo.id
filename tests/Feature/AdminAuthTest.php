<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_login_page_loads(): void
    {
        $this->get('/admin/login')->assertOk()->assertSee('Login ke panel admin');
    }

    public function test_admin_can_login_and_logout(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'password' => 'secret-password',
        ]);

        $this->post(route('admin.login.attempt'), [
            'email' => $admin->email,
            'password' => 'secret-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);

        $this->get('/admin')->assertOk()->assertSee('Dashboard');

        $this->post(route('admin.logout'))->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_login_with_wrong_password_fails(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'password' => 'secret-password',
        ]);

        $this->from('/admin/login')
            ->post(route('admin.login.attempt'), [
                'email' => $admin->email,
                'password' => 'salah',
            ])
            ->assertRedirect('/admin/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_non_admin_cannot_access_admin_area(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_non_admin_cannot_login(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'password' => 'secret-password',
        ]);

        $this->post(route('admin.login.attempt'), [
            'email' => $user->email,
            'password' => 'secret-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
