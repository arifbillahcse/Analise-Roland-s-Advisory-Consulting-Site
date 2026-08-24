<?php

namespace Tests\Feature;

use App\Mail\LeadAutoresponder;
use App\Mail\NewLeadReceived;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LeadSubmissionTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Jordan Rivers',
            'email' => 'jordan@example.com',
            'company' => 'Acme Co',
            'project' => 'We need help scoping a re-platform.',
            'source' => 'contact',
            'website' => '',
        ], $overrides);
    }

    public function test_a_valid_submission_creates_a_lead_and_sends_mail(): void
    {
        Mail::fake();

        $response = $this->post(route('leads.store'), $this->payload());

        $response->assertRedirect();
        $response->assertSessionHas('lead_sent', true);

        $this->assertDatabaseHas('leads', [
            'email' => 'jordan@example.com',
            'source' => 'contact',
            'status' => Lead::STATUS_NEW,
        ]);

        Mail::assertQueued(NewLeadReceived::class);
        Mail::assertQueued(LeadAutoresponder::class);
    }

    public function test_an_ajax_submission_gets_a_json_response(): void
    {
        Mail::fake();

        $response = $this->postJson(route('leads.store'), $this->payload());

        $response->assertOk()->assertJson(['success' => true]);
    }

    public function test_missing_required_fields_are_rejected(): void
    {
        $response = $this->postJson(route('leads.store'), $this->payload(['name' => '']));

        $response->assertStatus(422)->assertJsonValidationErrors('name');
        $this->assertDatabaseCount('leads', 0);
    }

    public function test_the_honeypot_field_silently_drops_the_submission(): void
    {
        Mail::fake();

        $response = $this->post(route('leads.store'), $this->payload(['website' => 'https://spam.example']));

        $response->assertRedirect();
        $response->assertSessionHas('lead_sent', true);

        $this->assertDatabaseCount('leads', 0);
        Mail::assertNothingQueued();
    }

    public function test_submissions_are_rate_limited_per_ip(): void
    {
        Mail::fake();

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('leads.store'), $this->payload(['email' => "lead{$i}@example.com"]))
                ->assertRedirect();
        }

        $this->post(route('leads.store'), $this->payload(['email' => 'lead6@example.com']))
            ->assertStatus(429);

        $this->assertDatabaseCount('leads', 5);
    }
}
