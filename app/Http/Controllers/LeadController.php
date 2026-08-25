<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Mail\LeadAutoresponder;
use App\Mail\NewLeadReceived;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request): JsonResponse|RedirectResponse
    {
        // Honeypot: a real visitor never sees or fills this field (it's
        // positioned off-screen). A bot that fills every input trips it.
        // Report success without touching the database, so the bot has no
        // signal that anything was different. StoreLeadRequest drops its
        // other rules when this is filled, so a bot that also submits
        // rubbish gets the same fake success rather than a 422 that would
        // point at the trap.
        if ($request->trippedHoneypot()) {
            return $this->success($request);
        }

        $validated = $request->validated();

        $lead = Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => ($validated['company'] ?? '') !== '' ? $validated['company'] : null,
            'message' => $validated['project'],
            'source' => $validated['source'],
            'status' => Lead::STATUS_NEW,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        $this->notify($lead);

        return $this->success($request);
    }

    /**
     * Send the admin notification and the sender's confirmation.
     *
     * The lead is already saved by this point, so a mail failure must not
     * turn a captured submission into a 500 for the visitor — it's logged
     * and swallowed. The record is still in the admin panel either way.
     */
    private function notify(Lead $lead): void
    {
        $adminEmail = config('site.admin_email');

        try {
            if (filled($adminEmail)) {
                Mail::to($adminEmail)->queue(new NewLeadReceived($lead));
            } else {
                Log::warning('Lead saved but not emailed: SITE_ADMIN_EMAIL is not set.', [
                    'lead_id' => $lead->id,
                ]);
            }

            Mail::to($lead->email)->queue(new LeadAutoresponder($lead));
        } catch (\Throwable $e) {
            Log::error('Lead notification mail failed.', [
                'lead_id' => $lead->id,
                'exception' => $e,
            ]);
        }
    }

    private function success(StoreLeadRequest $request): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        // Without JavaScript the browser lands back on the page it posted
        // from — at the top of it. The fragment puts the visitor back at the
        // form, where the success panel has replaced it.
        return back()->withFragment('book')->with('lead_sent', true);
    }
}
