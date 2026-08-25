<?php

namespace Tests\Feature;

use App\Mail\LeadAutoresponder;
use App\Mail\NewLeadReceived;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * These render the mailables for real, without Mail::fake().
 *
 * LeadSubmissionTest fakes the mailer, so it never touches a template — a
 * mailable that throws at render time (an undefined variable, a component
 * whose view namespace isn't registered, a route that no longer exists)
 * passes every test there and 500s the moment a visitor submits the form.
 * This is the test that catches that.
 */
class LeadMailTest extends TestCase
{
    use RefreshDatabase;

    private function lead(array $overrides = []): Lead
    {
        return Lead::create(array_merge([
            'name' => 'Jordan Rivers',
            'email' => 'jordan@example.com',
            'company' => 'Acme Co',
            'message' => 'We need help scoping a re-platform.',
            'source' => 'contact',
            'status' => Lead::STATUS_NEW,
        ], $overrides));
    }

    public function test_the_admin_notification_renders(): void
    {
        $lead = $this->lead();
        $rendered = (new NewLeadReceived($lead))->render();

        $this->assertStringContainsString('Jordan Rivers', $rendered);
        $this->assertStringContainsString('jordan@example.com', $rendered);
        $this->assertStringContainsString('Acme Co', $rendered);
        $this->assertStringContainsString('We need help scoping a re-platform.', $rendered);
    }

    public function test_the_admin_notification_links_to_the_lead_in_the_admin_panel(): void
    {
        $lead = $this->lead();
        $rendered = (new NewLeadReceived($lead))->render();

        // Filament's LeadResource has no "view" page — the deep link has to
        // point at the edit route, or it 404s.
        $this->assertStringContainsString("/admin/leads/{$lead->id}/edit", $rendered);
    }

    public function test_the_admin_notification_replies_to_the_sender(): void
    {
        $lead = $this->lead();
        $envelope = (new NewLeadReceived($lead))->envelope();

        $this->assertSame('jordan@example.com', $envelope->replyTo[0]->address);
    }

    public function test_the_notification_omits_the_company_line_when_there_is_no_company(): void
    {
        $rendered = (new NewLeadReceived($this->lead(['company' => null])))->render();

        $this->assertStringNotContainsString('Company:', $rendered);
    }

    public function test_the_autoresponder_renders(): void
    {
        $lead = $this->lead();
        $rendered = (new LeadAutoresponder($lead))->render();

        $this->assertStringContainsString('Jordan Rivers', $rendered);
        $this->assertStringContainsString('We need help scoping a re-platform.', $rendered);
    }

    public function test_a_submission_sends_real_mail_end_to_end(): void
    {
        // No Mail::fake() — the sync queue renders and hands both messages
        // to the array transport, exercising the whole path a visitor hits.
        $this->post(route('leads.store'), [
            'name' => 'Jordan Rivers',
            'email' => 'jordan@example.com',
            'company' => '',
            'project' => 'We need help scoping a re-platform.',
            'source' => 'contact',
            'website' => '',
        ])->assertRedirect();

        $this->assertDatabaseCount('leads', 1);

        // phpunit.xml pins MAIL_MAILER=array, so the sent messages are
        // collected on the transport instead of going anywhere.
        $this->assertCount(2, Mail::getSymfonyTransport()->messages());
    }
}
