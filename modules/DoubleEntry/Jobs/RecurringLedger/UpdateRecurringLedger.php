<?php

namespace Modules\DoubleEntry\Jobs\RecurringLedger;

use App\Abstracts\Job;

class UpdateRecurringLedger extends Job
{
    protected $request;

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
     * @param $request
     * @return void
     */
    public function __construct($ledger, $request)
    {
        $this->ledger = $ledger;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return \Modules\DoubleEntry\Models\Ledger
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->ledger->update($this->request->all());
        });

        return $this->ledger;
    }
}
