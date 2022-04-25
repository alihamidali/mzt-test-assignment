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

    public function contact()
    {
        // @todo
        // Your code goes here...
    }

    public function hire()
    {
        // @todo
        // Your code goes here...
    }
}
