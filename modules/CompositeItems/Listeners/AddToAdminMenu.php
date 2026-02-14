<?php

namespace Modules\CompositeItems\Listeners;

use App\Events\Menu\AdminCreated as Event;
use App\Traits\Modules;

class AddToAdminMenu
{
    use Modules;

    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (user()->cant('read-composite-items-composite-items') || $this->moduleIsEnabled('inventory')) {
            return;
        }

        $event->menu->add([
            'url' => route('composite-items.composite-items.index'),
            'title' => trans('composite-items::general.name'),
            'icon' => 'join_inner',
            'order' => 21,
        ]);
    }
}
