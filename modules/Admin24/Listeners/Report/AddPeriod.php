<?php

namespace Modules\Admin24\Listeners\Report;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterShowing;

class AddPeriod extends Listener
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

        $event->class->filters['period'] = $this->getPeriod();
        $event->class->filters['keys']['period'] = 'period';
        $event->class->filters['defaults']['period'] = $event->class->getSetting('period', 'quarterly');
        $event->class->filters['operators']['period'] = [
            'equal'     => true,
            'not_equal' => false,
            'range'     => false,
        ];
    }
}
