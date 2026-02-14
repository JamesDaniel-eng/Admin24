<?php

namespace Modules\Payroll\Jobs\Setting;

use App\Abstracts\Job;

class DeletePayItem extends Job
{
    protected $pay_item;

    /**
     * Create a new job instance.
     *
     * @param  $pay_item
     */
    public function __construct($pay_item)
    {
        $this->pay_item = $pay_item;
    }

    /**
     * Execute the job.
     *
     * @return boolean|Exception
     */
    public function handle()
    {
        $this->authorize();

        \DB::transaction(function () {
            $this->pay_item->delete();
        });
        
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
            $message = trans('messages.warning.deleted', ['name' => $this->pay_item->name, 'text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }
    }

    public function getRelationships()
    {
        $rels = [
            'benefits'  => 'benefits',
            'deduction' => 'deductions',
        ];

        return $this->countRelationships($this->pay_item, $rels);
    }
}
