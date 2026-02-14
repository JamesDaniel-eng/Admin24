<?php

namespace Modules\Admin24\Listeners;

use App\Events\Menu\SettingsCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class AddToSettingsMenu
{
    use Permissions, Modules;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (! $this->moduleIsEnabled('admin24')) {
            return;
        }

        $title = trim(trans('admin24::settings.quantities'));
        if ($this->canAccessMenuItem($title, 'read-admin24-settings')) {
            $event->menu->route('admin24.settings.quantities', $title, [], 41, ['icon' => 'scale', 'search_keywords' => trans('admin24::general.description')]);
        }
    }
}
