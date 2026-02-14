<?php

namespace Modules\Inventory\Listeners\Update;

use App\Events\Install\UpdateFinished;
use App\Abstracts\Listeners\Update as Listener;
use App\Utilities\Date;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class Version4112 extends Listener
{
    const ALIAS = 'inventory';

    const VERSION = '4.1.12';

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

        DB::table('reports')->where('class', 'Modules\Inventory\Reports\ItemSummary')->update([
            'deleted_at' => Date::now()->toDateTimeString()
        ]);
        
        File::delete(base_path('modules/Inventory/Reports/ItemSummary.php'));
    }
}
