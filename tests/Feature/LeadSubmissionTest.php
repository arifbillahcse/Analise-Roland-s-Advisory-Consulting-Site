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

    public function test_the_honeypot_wins_over_validation_so_a_bot_never_sees_a_422(): void
    {
        Mail::fake();

        // A bot that trips the honeypot *and* submits rubbish must get the
        // same fake success as one that filled the form properly. A 422
        // here would tell it which field gave it away.
        $response = $this->postJson(route('leads.store'), $this->payload([
            'website' => 'https://spam.example',
            'name' => '',
            'email' => 'not-an-email',
            'project' => '',
        ]));

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseCount('leads', 0);
        Mail::assertNothingQueued();
    }

    public function test_a_submission_from_an_unknown_source_page_is_rejected(): void
    {
        $this->postJson(route('leads.store'), $this->payload(['source' => 'elsewhere']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('source');

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_an_over_long_message_is_rejected(): void
    {
        $this->postJson(route('leads.store'), $this->payload(['project' => str_repeat('a', 4001)]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('project');
    }

    public function test_a_blank_company_is_stored_as_null_rather_than_an_empty_string(): void
    {
        Mail::fake();

        $this->post(route('leads.store'), $this->payload(['company' => '']))->assertRedirect();

        $this->assertNull(Lead::first()->company);
    }

    public function test_a_failed_no_js_submission_comes_back_with_errors_and_the_typed_input(): void
    {
        // The plain-HTML path: no Accept: application/json, so Laravel
        // redirects back rather than returning 422. The form has to render
        // the message and repopulate what was already typed.
        $this->from(route('contact'))
            ->post(route('leads.store'), $this->payload(['email' => '']))
            ->assertRedirect(route('contact').'#book')
            ->assertSessionHasErrors('email');

        $response = $this->from(route('contact'))
            ->followingRedirects()
            ->post(route('leads.store'), $this->payload(['email' => '']));

        $response->assertOk();
        $response->assertSee('Jordan Rivers', false);      // name survived
        $response->assertSee('We need help scoping a re-platform.', false);
        $response->assertSee('has-error', false);
    }

    public function test_a_successful_no_js_submission_lands_back_on_the_form(): void
    {
        Mail::fake();

        $this->from(route('contact'))
            ->post(route('leads.store'), $this->payload())
            ->assertRedirect(route('contact').'#book')
            ->assertSessionHas('lead_sent', true);
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
