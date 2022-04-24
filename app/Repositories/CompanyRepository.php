<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    private string $model = Company::class;

    public function getCoins($companyId)
    {
        return $this->model::find($companyId)->wallet->coins;
    }

    public function deductCoins($companyId, $amount)
    {
        $totalCoins = $this->model::find($companyId)->wallet->coins;
        $totalCoins -= $amount;

        return $this->model::find($companyId)->wallet->coins;
    }
}