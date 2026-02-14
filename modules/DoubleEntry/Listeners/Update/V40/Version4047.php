<?php

namespace Modules\DoubleEntry\Listeners\Update\V40;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use Illuminate\Support\Facades\File;

class Version4047 extends Listener
{
    const ALIAS = 'double-entry';

    const VERSION = '4.0.47';

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(UpdateFinished $event)
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        $this->deleteOldFiles();
    }

    public function deleteOldFiles(): void
    {
        $files = [
            'Exports/COA.php',
            'Imports/COAphp',
            'Jobs/Account/ImportAccount.php',
            'Jobs/Journal/ImportJournalEntry.php',
        ];

        foreach ($files as $file) {
            File::delete(base_path('modules/DoubleEntry/' . $file));
        }
    }
}
