<?php

namespace App\Http\Requests\Domain;

use App\Rules\FQDN;
use Illuminate\Foundation\Http\FormRequest;

class DomainStringRequest extends FormRequest
{
    public function rules()
    {
        return [
            'domain' => ['required', 'string', new FQDN],
        ];
    }

    public function getDomains(): array
    {
        return explode(';', $this->validated()['domain']);
    }
}
