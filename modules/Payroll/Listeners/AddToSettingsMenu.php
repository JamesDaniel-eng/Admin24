<?php

namespace Modules\Payroll\Listeners;

use App\Events\Menu\SettingsCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class AddToSettingsMenu
{
    use Modules, Permissions;

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

        $title = trans('payroll::general.name');

        if ($this->canAccessMenuItem($title, 'read-payroll-settings')) {
            $event->menu->route('payroll.settings.edit', $title, [], 253, ['icon' => 'calculate', 'search_keywords' => trans('payroll::general.description')]);
        }
    }
}
