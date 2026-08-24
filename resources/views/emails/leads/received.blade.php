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

<x-mail::button :url="url('/admin/leads/'.$lead->id)">
View in admin
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
