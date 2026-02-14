<?php

namespace Modules\Payroll\Listeners;

use App\Traits\Modules;
use Modules\Employees\Events\AddingHRDropdown;

class ShowHRDropdown
{
    use Modules;

    public function handle(AddingHRDropdown $event)
    {
        if ($this->moduleIsDisabled('payroll')) {
            return;
        }

        if (user()->can([
            'read-payroll-payroll',
            'read-payroll-pay-calendars',
            'read-payroll-run-payrolls',
        ])) {
            $event->show_dropdown = true;

            return false;
        }
    }
}
