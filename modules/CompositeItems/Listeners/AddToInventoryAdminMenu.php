<?php

namespace Modules\CompositeItems\Listeners;

use Modules\Inventory\Events\AdminMenu as Event;

class AddToInventoryAdminMenu
{
    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (user()->cant('read-composite-items-composite-items')) {
            return;
        }

        $item = $event->menu->whereTitle(trim(trans('inventory::general.menu.inventory')));

        $item->url(route('composite-items.composite-items.index'), trans('composite-items::general.name'), 12, []);
    }
}