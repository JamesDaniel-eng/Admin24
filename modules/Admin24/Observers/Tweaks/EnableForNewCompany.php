<?php

namespace Modules\Admin24\Observers\Tweaks;

use App\Abstracts\Observer;
use Illuminate\Support\Facades\File;
use App\Models\Common\Company;
use Artisan;

class EnableForNewCompany extends Observer
{
    public function created(Company $company): void
    {
        $company_id = $company->id;

        Artisan::call('module:enable', [
            'name' => 'admin24',
            'company' => $company_id,
        ]);
    }
}