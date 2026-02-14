<?php

namespace Modules\Payroll\Jobs\PayCalendar;

use App\Abstracts\Job;

class DeletePayCalendar extends Job
{
    protected $pay_calendar;

    /**
     * Create a new job instance.
     *
     * @param  $pay_calendar
     */
    public function __construct($pay_calendar)
    {
        $this->pay_calendar = $pay_calendar;
    }

    /**
     * Execute the job.
     *
     * @return boolean|Exception
     */
    public function handle()
    {
        $this->authorize();

        $this->deleteRelationships($this->pay_calendar, [
            'employees',
        ]);

        $this->pay_calendar->delete();

        return true;
    }

        /**
     * Determine if this action is applicable.
     *
     * @return void
     */
    public function authorize()
    {
        if ($relationships = $this->getRelationships()) {
            $message = trans('messages.warning.deleted', ['name' => $this->pay_calendar->name, 'text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }
    }

    public function getRelationships()
    {
        $rels = [
            'run_payrolls' => 'payroll::general.run_payrolls',
        ];

        return $this->countRelationships($this->pay_calendar, $rels);
    }
}
