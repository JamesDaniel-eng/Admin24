<?php

namespace Modules\Payroll\Listeners;

use App\Traits\Modules;
use Modules\Employees\Events\HRDropdownCreated as Event;

class AddToEmployeeMenu
{
    use Modules;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($this->moduleIsDisabled('payroll')) {
            return;
        }

        $user = user();

        if (! $user->can('read-payroll-pay-slips')) {
            return;
        }

        if ($user->can('read-payroll-pay-slips')) {
            $event->menu->route('payroll.pay-slips.index', trans_choice('payroll::general.pay_slips', 2), [], 30, []);
        }
    }
}
