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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'company' => ['nullable', 'string', 'max:120'],
            'project' => ['required', 'string', 'max:4000'],
            'source' => ['required', Rule::in(['home', 'contact'])],
            // Honeypot: hidden from real visitors via CSS. Checked (not
            // validated) in the controller so a bot gets a fake success
            // instead of a validation error hinting at the trap.
            'website' => ['nullable', 'string'],
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
}
