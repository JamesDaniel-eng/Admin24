<?php

namespace Modules\Admin24\Listeners;

use Akaunting\Menu\MenuBuilder;
use App\Events\Menu\AdminCreated as Event;

class AdminMenu {

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */

    public function handle(Event $event) {
        // Add Businesses menu item for Clients' Businesses
        $event->menu->removeByTitle('Items');
        $event->menu->removeByTitle('Sales');
        $event->menu->removeByTitle('Apps');
        $event->menu->dropdown('Clients', function ($sub) {
            $sub->route('admin24.businesses', 'Businesses', [], 10, ['icon' => '']);
            $sub->route('customers.index', 'Contacts', [], 15, ['icon' => '']);
            $sub->route('invoices.index', 'Invoices', [], 20, ['icon' => '']);
        }, 15, [
            'title' => 'User Accounts',
            'icon' => 'account_tree',
        ]);

        $event->menu->whereTitle('Purchases', function ($sub) {
            $sub->route('items.index', 'Items', [], 1, ['icon' => '']);
        });
    }
}