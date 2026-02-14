<?php

namespace Modules\DoubleEntry\Jobs\Journal;

use App\Abstracts\Job;
use App\Traits\Relationships;
use App\Interfaces\Job\ShouldDelete;
use Modules\DoubleEntry\Events\Journal\JournalDeleted;

class DeleteJournalEntry extends Job implements ShouldDelete
{
    use Relationships;

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->authorize();

        \DB::transaction(function () {
            $this->deleteRelationships($this->model, ['ledgers']);
            $this->model->delete();
        });

        event(new JournalDeleted($this->model));

        return true;
    }

    /**
     * Determine if this action is applicable.
     */
    public function authorize(): void
    {
        if ($this->model->reconciled) {
            $message = trans('double-entry::messages.warning.ledger');

            throw new \Exception($message);
        }
    }
}
