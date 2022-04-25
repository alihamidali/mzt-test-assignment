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

}