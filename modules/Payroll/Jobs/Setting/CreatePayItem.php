<?php

namespace Modules\Payroll\Jobs\Setting;

use App\Abstracts\Job;
use Modules\Payroll\Models\Setting\PayItem;

class CreatePayItem extends Job
{
    protected $request;

    /**
     * Create a new job instance.
     *
     * @param  $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return PayItem
     */
    public function handle()
    {
        return PayItem::create($this->request);
    }
}
