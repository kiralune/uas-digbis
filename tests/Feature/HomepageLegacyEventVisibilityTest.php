<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageLegacyEventVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_does_not_show_legacy_event_without_organization(): void
    {
        $organization = Organization::create([
            'name' => 'Organisasi Test',
            'slug' => 'organisasi-test',
            'status' => 'active',
        ]);

        $category = Category::create([
            'name' => 'UI/UX',
            'slug' => 'ui-ux',
        ]);

        Event::create([
            'organization_id' => null,
            'category_id' => $category->id,
            'title' => 'Legacy Event UI/UX Demo',
            'description' => 'Event legacy yang seharusnya tidak tampil di homepage.',
            'date' => now()->addDay(),
            'location' => 'Jakarta',
            'price' => 100000,
            'stock' => 50,
            'poster_path' => null,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Legacy Event UI/UX Demo');
    }
}
