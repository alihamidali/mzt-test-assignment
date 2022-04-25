<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public string $model = Company::class;

    use Eloquent;
}