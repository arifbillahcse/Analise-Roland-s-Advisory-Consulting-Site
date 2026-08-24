<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The admin panel is the whole reason this site has a database, and none of
 * it was covered: that /admin is closed to the public, that the seeded
 * account can actually open it, and that the resource routes resolve.
 */
class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_admin_panel_is_closed_to_guests(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_the_lead_list_is_closed_to_guests(): void
    {
        $this->get('/admin/leads')->assertRedirect('/admin/login');
    }

    public function test_the_login_page_renders(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_a_signed_in_user_reaches_the_dashboard(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertOk();
    }

    /**
     * @return array<string, array{string}>
     */
    public static function resourceIndexes(): array
    {
        return [
            'leads' => ['/admin/leads'],
            'testimonials' => ['/admin/testimonials'],
            'case studies' => ['/admin/case-studies'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('resourceIndexes')]
    public function test_each_resource_index_renders(string $path): void
    {
        $this->actingAs(User::factory()->create())
            ->get($path)
            ->assertOk();
    }

    public function test_a_lead_can_be_opened_for_editing(): void
    {
        $lead = Lead::create([
            'name' => 'Jordan Rivers',
            'email' => 'jordan@example.com',
            'message' => 'Hello.',
            'source' => 'contact',
            'status' => Lead::STATUS_NEW,
        ]);

        $this->actingAs(User::factory()->create())
            ->get("/admin/leads/{$lead->id}/edit")
            ->assertOk();
    }

    public function test_the_seeder_creates_a_working_admin_login(): void
    {
        config([
            'site.admin.email' => 'admin@example.com',
            'site.admin.password' => 'correct-horse-battery',
            'site.admin.name' => 'Analise Roland',
        ]);

        $this->seed(\Database\Seeders\AdminUserSeeder::class);

        $user = User::where('email', 'admin@example.com')->first();

        $this->assertNotNull($user, 'The seeder should have created the admin account.');
        $this->assertTrue(
            \Illuminate\Support\Facades\Hash::check('correct-horse-battery', $user->password),
            'The seeded password should verify — a double-hash would break login.'
        );
    }

    public function test_the_seeder_updates_the_existing_account_rather_than_duplicating_it(): void
    {
        config([
            'site.admin.email' => 'admin@example.com',
            'site.admin.password' => 'first-password',
            'site.admin.name' => 'Analise Roland',
        ]);
        $this->seed(\Database\Seeders\AdminUserSeeder::class);

        config(['site.admin.password' => 'second-password']);
        $this->seed(\Database\Seeders\AdminUserSeeder::class);

        $this->assertSame(1, User::where('email', 'admin@example.com')->count());
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check(
            'second-password',
            User::where('email', 'admin@example.com')->first()->password
        ));
    }
}
