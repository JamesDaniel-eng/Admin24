<?php

namespace Modules\Admin24\Listeners\Report;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterApplying;
use App\Events\Report\FilterShowing;

class AddDate extends Listener
{
    protected $classes = [
        'Modules\Admin24\Reports\InventoryTransfers',
        'Modules\Admin24\Reports\ProductionStockStatus',
    ];

    /**
     * Handle filter showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleFilterShowing(FilterShowing $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $this->setDateFilter($event);
    }

    /**
     * Handle filter applying event.
     *
     * @param  $event
     * @return void
     */
    public function handleFilterApplying(FilterApplying $event)
    {
        if (empty($event->args['date_field'])) {
            return;
        }

        // Apply date
        $this->applyDateFilter($event);
    }
}
