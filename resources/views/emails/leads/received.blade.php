<x-mail::message>
# New lead from the site

**Name:** {{ $lead->name }}
**Email:** {{ $lead->email }}
@if ($lead->company)
**Company:** {{ $lead->company }}
@endif
**Source:** {{ ucfirst($lead->source) }} page

**Message:**

{{ $lead->message }}

{{-- The panel is named explicitly: this renders from a queued job, which has
     no request to infer the current Filament panel from. --}}
<x-mail::button :url="\App\Filament\Resources\LeadResource::getUrl('edit', ['record' => $lead], panel: 'admin')">
View in admin
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
