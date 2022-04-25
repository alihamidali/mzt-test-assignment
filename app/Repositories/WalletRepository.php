<?php

namespace App\Repositories;

use App\Models\Candidate;
use App\Models\Company;
use App\Models\Wallet;

class WalletRepository
{
    public string $model = Wallet::class;

    use Eloquent;

    public function findWalletByCompanyId($companyId)
    {
        return $this->findBy('company_id', $companyId)->first();
    }

    public function getCoins(Company $company)
    {
        return $this->findWalletByCompanyId($company->id)->coins;
    }

    /**
     * @throws \Exception
     */
    public function deductCoins($company, $amount)
    {
        $wallet = $this->findWalletByCompanyId($company->id);
        $totalCoins = $wallet->coins;

        if ($totalCoins <= 0) {
            throw new \Exception('Out of coins!');
        }

        $totalCoins -= $amount;

        $wallet->coins = $totalCoins;
        return $wallet->save();
    }

    /**
     * @throws \Exception
     */
    public function refundCoins($company, $amount)
    {
        $wallet = $this->findWalletByCompanyId($company->id);
        $totalCoins = $wallet->coins;
        $totalCoins += $amount;

        $wallet->coins = $totalCoins;
        return $wallet->save();
    }
}