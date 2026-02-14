<?php

namespace Modules\Payroll\Jobs\RunPayroll;

use App\Abstracts\Job;
use App\Models\Banking\Account;
use App\Interfaces\Job\ShouldUpdate;
use Modules\Payroll\Models\RunPayroll\RunPayroll;

class UpdateRunPayroll extends Job implements ShouldUpdate
{
    public function handle(): RunPayroll
    {
        \DB::transaction(function () {
            $account = Account::find($this->request->account_id);
            
            if ($account) {
                $this->request->merge([
                    'currency_code' => $account->currency->code ?? setting('default.currency'),
                    'currency_rate' => $account->currency->rate ?? 1,
                ]);
            }

            $this->model->update($this->request->all());
        });

        return $this->model;
    }

}
