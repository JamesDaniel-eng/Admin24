<?php

namespace Modules\CompositeItems\Listeners;

use App\Events\Menu\ItemAuthorizing as Event;

class AuthorizeDropdownMenu
{
    public function handle(Event $event)
    {
        if ($event->item->title !== trim(trans('inventory::general.menu.inventory'))) {
            return;
        }

        $event->item->permissions[] = 'read-composite-items-composite-items';
    }
}
