<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin Demo',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Admin');
        $response->assertSee('Manajemen Organizer');
    }

    public function test_admin_login_page_is_available(): void
    {
        $response = $this->get(route('admin_auth.login'));

        $response->assertStatus(200);
        $response->assertSee('Login Admin');
    }
}
