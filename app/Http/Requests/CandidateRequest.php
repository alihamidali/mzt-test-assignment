<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;

class CandidateRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'contact_id' => 'exists:App\Models\Candidate,id',
            'company_id' => 'exists:App\Models\Company,id'
        ];
    }
}