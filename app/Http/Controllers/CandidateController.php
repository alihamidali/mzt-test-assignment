<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateRequest;
use App\Services\CandidateService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CandidateController extends Controller
{
    /**
     * @var CandidateService
     */
    private CandidateService $candidateService;

    /**
     * @param CandidateService $candidateService
     */
    public function __construct(
        CandidateService $candidateService
    ) {
        $this->candidateService = $candidateService;
    }

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        list($candidates, $company, $coins) = $this->candidateService->getCandidatesAndCompanyCoins();

        return view('candidates.index', compact('candidates', 'coins', 'company'));
    }

    /**
     * @param CandidateRequest $request
     * @return array
     */
    public function contact(CandidateRequest $request): array
    {
        $candidateId    = $request->get('candidate_id');
        $companyId      = $request->get('company_id');

        list($status, $message) = $this->candidateService->contactCandidate($candidateId, $companyId);

        return [
            'status'    => $status,
            'message'   => $message
        ];

    }

    /**
     * @param CandidateRequest $request
     * @return array
     */
    public function hire(CandidateRequest $request): array
    {
        $candidateId    = $request->get('candidate_id');
        $companyId      = $request->get('company_id');

        list($status, $message) = $this->candidateService->hireCandidate($candidateId, $companyId);

        return [
            'status'    => $status,
            'message'   => $message
        ];
    }
}
