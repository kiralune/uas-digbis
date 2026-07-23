<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Transaction;
use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_see_all_tenants_events_and_transactions()
    {
        $orgA = Organization::create(['name' => 'Tenant A', 'slug' => 'tenant-a', 'status' => 'active']);
        $orgB = Organization::create(['name' => 'Tenant B', 'slug' => 'tenant-b', 'status' => 'active']);
        $category = Category::create(['name' => 'Conference', 'slug' => 'conference']);

        Event::create([
            'organization_id' => $orgA->id,
            'category_id' => $category->id,
            'title' => 'Event A',
            'description' => 'Event A description',
            'date' => now()->addDays(10),
            'location' => 'Venue A',
            'price' => 100000,
            'stock' => 50,
        ]);

        Event::create([
            'organization_id' => $orgB->id,
            'category_id' => $category->id,
            'title' => 'Event B',
            'description' => 'Event B description',
            'date' => now()->addDays(15),
            'location' => 'Venue B',
            'price' => 150000,
            'stock' => 40,
        ]);

        Transaction::create([
            'organization_id' => $orgA->id,
            'event_id' => Event::where('title', 'Event A')->first()->id,
            'order_id' => 'ORDER-A-1',
            'customer_name' => 'Customer A',
            'customer_email' => 'customer.a@example.test',
            'customer_phone' => '081234567890',
            'total_price' => 100000,
            'status' => 'success',
            'snap_token' => 'token-a',
        ]);

        Transaction::create([
            'organization_id' => $orgB->id,
            'event_id' => Event::where('title', 'Event B')->first()->id,
            'order_id' => 'ORDER-B-1',
            'customer_name' => 'Customer B',
            'customer_email' => 'customer.b@example.test',
            'customer_phone' => '081234567891',
            'total_price' => 150000,
            'status' => 'success',
            'snap_token' => 'token-b',
        ]);

        $superadmin = User::create([
            'name' => 'Super Organizer',
            'email' => 'superadmin@example.test',
            'password' => 'password',
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($superadmin)->get(route('organizer.events.index'));
        $response->assertStatus(200);
        $response->assertSee('Event A');
        $response->assertSee('Event B');

        $response = $this->actingAs($superadmin)->get(route('organizer.transactions.index'));
        $response->assertStatus(200);
        $response->assertSee('ORDER-A-1');
        $response->assertSee('ORDER-B-1');
    }

    public function test_organizer_a_only_sees_own_events_and_transactions()
    {
        $orgA = Organization::create(['name' => 'Tenant A', 'slug' => 'tenant-a', 'status' => 'active']);
        $orgB = Organization::create(['name' => 'Tenant B', 'slug' => 'tenant-b', 'status' => 'active']);
        $category = Category::create(['name' => 'Conference', 'slug' => 'conference']);

        $eventA = Event::create([
            'organization_id' => $orgA->id,
            'category_id' => $category->id,
            'title' => 'Event A',
            'description' => 'Event A description',
            'date' => now()->addDays(10),
            'location' => 'Venue A',
            'price' => 100000,
            'stock' => 50,
        ]);

        Event::create([
            'organization_id' => $orgB->id,
            'category_id' => $category->id,
            'title' => 'Event B',
            'description' => 'Event B description',
            'date' => now()->addDays(15),
            'location' => 'Venue B',
            'price' => 150000,
            'stock' => 40,
        ]);

        Transaction::create([
            'organization_id' => $orgA->id,
            'event_id' => $eventA->id,
            'order_id' => 'ORDER-A-1',
            'customer_name' => 'Customer A',
            'customer_email' => 'customer.a@example.test',
            'customer_phone' => '081234567890',
            'total_price' => 100000,
            'status' => 'success',
            'snap_token' => 'token-a',
        ]);

        Transaction::create([
            'organization_id' => $orgB->id,
            'event_id' => Event::where('title', 'Event B')->first()->id,
            'order_id' => 'ORDER-B-1',
            'customer_name' => 'Customer B',
            'customer_email' => 'customer.b@example.test',
            'customer_phone' => '081234567891',
            'total_price' => 150000,
            'status' => 'success',
            'snap_token' => 'token-b',
        ]);

        $organizerA = User::create([
            'organization_id' => $orgA->id,
            'name' => 'Organizer A',
            'email' => 'organizer.a@example.test',
            'password' => 'password',
            'role' => 'organizer',
        ]);

        $response = $this->actingAs($organizerA)->get(route('organizer.events.index'));
        $response->assertStatus(200);
        $response->assertSee('Event A');
        $response->assertDontSee('Event B</p>');

        $response = $this->actingAs($organizerA)->get(route('organizer.transactions.index'));
        $response->assertStatus(200);
        $response->assertSee('ORDER-A-1');
        $response->assertDontSee('ORDER-B-1');
    }

    public function test_organizer_b_cannot_open_organizer_a_event()
    {
        $orgA = Organization::create(['name' => 'Tenant A', 'slug' => 'tenant-a', 'status' => 'active']);
        $orgB = Organization::create(['name' => 'Tenant B', 'slug' => 'tenant-b', 'status' => 'active']);
        $category = Category::create(['name' => 'Conference', 'slug' => 'conference']);

        $eventA = Event::create([
            'organization_id' => $orgA->id,
            'category_id' => $category->id,
            'title' => 'Event A',
            'description' => 'Event A description',
            'date' => now()->addDays(10),
            'location' => 'Venue A',
            'price' => 100000,
            'stock' => 50,
        ]);

        $organizerB = User::create([
            'organization_id' => $orgB->id,
            'name' => 'Organizer B',
            'email' => 'organizer.b@example.test',
            'password' => 'password',
            'role' => 'organizer',
        ]);

        $response = $this->actingAs($organizerB)->get(route('organizer.events.edit', $eventA->id));
        $response->assertStatus(403);
    }

    public function test_organizer_dashboard_shows_only_own_transactions()
    {
        $orgA = Organization::create(['name' => 'Tenant A', 'slug' => 'tenant-a', 'status' => 'active']);
        $orgB = Organization::create(['name' => 'Tenant B', 'slug' => 'tenant-b', 'status' => 'active']);
        $category = Category::create(['name' => 'Conference', 'slug' => 'conference']);

        $eventA = Event::create([
            'organization_id' => $orgA->id,
            'category_id' => $category->id,
            'title' => 'Event A',
            'description' => 'Event A description',
            'date' => now()->addDays(10),
            'location' => 'Venue A',
            'price' => 100000,
            'stock' => 50,
        ]);

        Event::create([
            'organization_id' => $orgB->id,
            'category_id' => $category->id,
            'title' => 'Event B',
            'description' => 'Event B description',
            'date' => now()->addDays(15),
            'location' => 'Venue B',
            'price' => 150000,
            'stock' => 40,
        ]);

        Transaction::create([
            'organization_id' => $orgA->id,
            'event_id' => $eventA->id,
            'order_id' => 'ORDER-A-1',
            'customer_name' => 'Customer A',
            'customer_email' => 'customer.a@example.test',
            'customer_phone' => '081234567890',
            'total_price' => 100000,
            'status' => 'success',
            'snap_token' => 'token-a',
        ]);

        Transaction::create([
            'organization_id' => $orgB->id,
            'event_id' => Event::where('title', 'Event B')->first()->id,
            'order_id' => 'ORDER-B-1',
            'customer_name' => 'Customer B',
            'customer_email' => 'customer.b@example.test',
            'customer_phone' => '081234567891',
            'total_price' => 150000,
            'status' => 'success',
            'snap_token' => 'token-b',
        ]);

        $organizerA = User::create([
            'organization_id' => $orgA->id,
            'name' => 'Organizer A',
            'email' => 'organizer.a@example.test',
            'password' => 'password',
            'role' => 'organizer',
        ]);

        $response = $this->actingAs($organizerA)->get(route('organizer.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Organizer');
        $response->assertSee('Analitik Pendapatan');
        $response->assertSee('ORDER-A-1');
        $response->assertDontSee('ORDER-B-1');
    }

    public function test_organizer_is_redirected_to_organizer_dashboard()
    {
        $orgA = Organization::create(['name' => 'Tenant A', 'slug' => 'tenant-a', 'status' => 'active']);
        $organizerA = User::create([
            'organization_id' => $orgA->id,
            'name' => 'Organizer A',
            'email' => 'organizer.a@example.test',
            'password' => 'password',
            'role' => 'organizer',
        ]);

        $response = $this->actingAs($organizerA)->get(route('organizer.home'));
        $response->assertRedirect(route('organizer.dashboard'));
    }

    public function test_organizer_login_redirects_to_organizer_dashboard()
    {
        $orgA = Organization::create(['name' => 'Tenant A', 'slug' => 'tenant-a', 'status' => 'active']);
        $organizerA = User::create([
            'organization_id' => $orgA->id,
            'name' => 'Organizer A',
            'email' => 'organizer.login@example.test',
            'password' => 'password',
            'role' => 'organizer',
        ]);

        $response = $this->post(route('organizer_auth.login.post'), [
            'email' => $organizerA->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('organizer.dashboard'));
        $this->assertAuthenticatedAs($organizerA);
    }

    public function test_organizer_registration_redirects_to_organizer_dashboard()
    {
        $response = $this->post(route('organizer_auth.register.post'), [
            'name' => 'Organizer Baru',
            'email' => 'organizer.register@example.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('organizer.dashboard'));

        $user = User::where('email', 'organizer.register@example.test')->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->organization_id);
        $this->assertAuthenticatedAs($user);
    }
}
