<?php

namespace App\Services;

use App\Events\EmailNotification;
use App\Repositories\CandidateRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CandidateService
{
    const HIRING_FEE = 5;
    private CandidateRepository $candidateRepository;
    private CompanyRepository $companyRepository;
    private WalletRepository $walletRepository;

    /**
     * @param CandidateRepository $candidateRepository
     * @param CompanyRepository $companyRepository
     * @param WalletRepository $walletRepository
     */
    public function __construct(
        CandidateRepository $candidateRepository,
        CompanyRepository $companyRepository,
        WalletRepository $walletRepository
    ) {
        $this->candidateRepository = $candidateRepository;
        $this->companyRepository = $companyRepository;
        $this->walletRepository = $walletRepository;
    }

    /**
     * @return array
     */
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

    /**
     * @param $candidateId
     * @param $companyId
     * @return array
     */
    public function contactCandidate($candidateId, $companyId): array
    {
        $candidate  = $this->candidateRepository->find($candidateId);
        $company    = $this->companyRepository->find($companyId);
        $status     = true;
        $message    = '';

        try {
            DB::beginTransaction();

            $this->candidateRepository->updateContactedBy($candidate, $company);
            $this->walletRepository->deductCoins($company, self::HIRING_FEE);

            EmailNotification::dispatch($company, $candidate, 'contact');

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

    /**
     * @param $candidateId
     * @param $companyId
     * @return array
     */
    public function hireCandidate($candidateId, $companyId): array
    {
        $candidate = $this->candidateRepository->find($candidateId);
        $company = $this->companyRepository->find($companyId);
        $status     = true;
        $message    = '';

        try {

            if ($candidate->contacted_by !== $company->id) {
                throw new \Exception('This candidate has not been contacted yet!');
            }

            DB::beginTransaction();

            $this->candidateRepository->updateHiredBy($candidate, $company);
            $this->walletRepository->refundCoins($company, self::HIRING_FEE);

            EmailNotification::dispatch($company, $candidate, 'hired');

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