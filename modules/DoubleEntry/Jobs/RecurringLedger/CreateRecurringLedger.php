<?php

namespace Modules\DoubleEntry\Jobs\RecurringLedger;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use Modules\DoubleEntry\Models\RecurringLedger;

class CreateRecurringLedger extends Job implements HasOwner, HasSource, ShouldCreate
{
    /**
     * Execute the job.
     *
     * @return \Modules\DoubleEntry\Models\RecurringLedger
     */
    public function handle(): RecurringLedger
    {
        \DB::transaction(function () {
            $this->model = RecurringLedger::create($this->request->all());
        });

        return $this->model;
    }
}
