<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Did this submission fill the hidden honeypot field?
     *
     * Real visitors never see it, so anything in it means a bot.
     */
    public function trippedHoneypot(): bool
    {
        return filled($this->input('website'));
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        // A tripped honeypot skips validation entirely. The controller
        // answers with a fake success, and a bot that also submitted
        // rubbish never sees a 422 pointing at which field gave it away.
        if ($this->trippedHoneypot()) {
            return [];
        }

        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'company' => ['nullable', 'string', 'max:120'],
            'project' => ['required', 'string', 'max:4000'],
            'source' => ['required', Rule::in(['home', 'contact'])],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'project' => 'project details',
        ];
    }

    /**
     * Send a failed no-JS submission back to the form itself, not to the
     * top of the page it posted from.
     */
    protected function getRedirectUrl(): string
    {
        return $this->redirector->getUrlGenerator()->previous().'#book';
    }
}
