<?php

namespace Modules\DoubleEntry\Jobs\RecurringLedger;

use App\Abstracts\Job;

class DeleteRecurringLedger extends Job
{
    /**
     * The ledger instance.
     *
     * @var \Modules\DoubleEntry\Models\RecurringLedger
     */
    protected $ledger;

    /**
     * Create a new job instance.
     *
     * @param \Modules\DoubleEntry\Models\RecurringLedger $ledger
     * @return void
     */
    public function __construct($ledger)
    {
        $this->ledger = $ledger;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->ledger->delete();
        });

        return true;
    }
}
