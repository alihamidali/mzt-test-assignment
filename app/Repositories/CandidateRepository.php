<?php

namespace App\Repositories;

use App\Models\Candidate;

class CandidateRepository
{
    public string $model = Candidate::class;

    use Eloquent;

    /**
     * @param $candidate
     * @param $company
     * @return void
     */
    public function updateContactedBy($candidate, $company)
    {
        $candidate->contacted_by = $company->id;
        $candidate->save();
    }

    /**
     * @param $candidate
     * @param $company
     * @return void
     */
    public function updateHiredBy($candidate, $company)
    {
        $candidate->hired_by = $company->id;
        $candidate->save();
    }
}