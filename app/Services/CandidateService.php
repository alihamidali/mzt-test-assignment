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

    public function contactCandidate($candidateId, $companyId)
    {
        $candidate  = $this->candidateRepository->find($candidateId);
        $company    = $this->companyRepository->find($companyId);
        $status     = true;
        $message    = '';

        try {
            DB::beginTransaction();

            $this->candidateRepository->updateContactedBy($candidate, $company);
            $this->walletRepository->deductCoins($company, self::HIRING_FEE);

            CandidateContactedByCompany::dispatch($company, $candidate);

            DB::commit();
        } catch (\Exception $exception) {

            Log::error($exception->getMessage());
            DB::rollBack();

            $status     = false;
            $message    = $exception->getMessage();
        }

        return [
            $status,
            $message,
        ];
    }

}