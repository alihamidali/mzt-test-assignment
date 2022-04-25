<?php

namespace App\Repositories;

use App\Models\Candidate;
use App\Models\Company;

class CandidateRepository
{
    public string $model = Candidate::class;

    use Eloquent;

    public function updateContactedBy($candidate, $company)
    {
        $candidate->contacted_by = $company->id;
        $candidate->save();
    }
}