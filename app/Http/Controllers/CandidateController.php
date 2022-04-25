<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactCandidateRequest;
use App\Services\CandidateService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CandidateController extends Controller
{
    private CandidateService $candidateService;

    public function __construct(
        CandidateService $candidateService
    ) {
        $this->candidateService = $candidateService;
    }

    public function index(): Factory|View|Application
    {
        list($candidates, $company, $coins) = $this->candidateService->getCandidatesAndCompanyCoins();

        return view('candidates.index', compact('candidates', 'coins', 'company'));
    }

    public function contact(ContactCandidateRequest $request): array
    {
        $candidateId    = $request->get('candidate_id');
        $companyId      = $request->get('company_id');

        list($status, $message) = $this->candidateService->contactCandidate($candidateId, $companyId);

        return [
            'status'    => $status,
            'message'   => $message
        ];

    }

    public function hire()
    {
        // @todo
        // Your code goes here...
    }
}
