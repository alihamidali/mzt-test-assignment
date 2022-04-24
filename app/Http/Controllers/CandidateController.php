<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Company;
use App\Repositories\CompanyRepository;

class CandidateController extends Controller
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        $candidates = Candidate::all();
        $coins = $this->companyRepository->getCoins(1);

        return view('candidates.index', compact('candidates', 'coins'));
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
