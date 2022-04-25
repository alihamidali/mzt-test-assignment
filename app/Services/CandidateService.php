<?php

namespace App\Services;

use App\Events\CandidateContactedByCompany;
use App\Models\Candidate;
use App\Repositories\CandidateRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class CandidateService
{
    const HIRING_FEE = 5;
    private CandidateRepository $candidateRepository;
    private CompanyRepository $companyRepository;
    private WalletRepository $walletRepository;

    public function __construct(CandidateRepository $candidateRepository, CompanyRepository $companyRepository, WalletRepository $walletRepository)
    {
        $this->candidateRepository = $candidateRepository;
        $this->companyRepository = $companyRepository;
        $this->walletRepository = $walletRepository;
    }

    public function getCandidatesAndCompanyCoins(): array
    {
        $candidates = $this->candidateRepository->getAll();
        $company = $this->companyRepository->getFirst();
        $coins = $this->walletRepository->getCoins($company);

        return [
            $candidates,
            $company,
            $coins
        ];
    }

}