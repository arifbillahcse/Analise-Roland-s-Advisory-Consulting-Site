<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Mail\LeadAutoresponder;
use App\Mail\NewLeadReceived;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request): JsonResponse|RedirectResponse
    {
        // Honeypot: a real visitor never sees or fills this field (it's
        // hidden off-screen in CSS). A bot that fills every input trips it.
        // Report success without touching the database, so the bot has no
        // signal that anything was different.
        if (filled($request->input('website'))) {
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

        Mail::to(config('site.admin_email'))->queue(new NewLeadReceived($lead));
        Mail::to($lead->email)->queue(new LeadAutoresponder($lead));

        return $this->success($request);
    }

    private function success(StoreLeadRequest $request): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('lead_sent', true);
    }
}
