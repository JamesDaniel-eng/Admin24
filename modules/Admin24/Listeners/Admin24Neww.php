<?php

namespace Modules\Admin24\Listeners;

use App\Events\Menu\NewwCreated as Event;
use App\Traits\Permissions;

class Admin24Neww
{
    use Permissions;

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $menu = $event->menu;

        if ($this->canAccessMenuItem('Expenses', 'create-admin24-portal-expenses')) {
            $menu->route('portal.admin24.showexpenses', 'Create an Expense', [], 10, ['icon' => 'receipt_long']);
        }
        
        if ($this->canAccessMenuItem('Assets', 'create-admin24-portal-assets')) {
            $menu->route('portal.admin24.showassets', 'Create an Asset', [], 20, ['icon' => 'request_quote']);
        }
        
        if ($this->canAccessMenuItem('Banking', 'create-admin24-portal-banking')) {
            $menu->route('portal.admin24.accounts', 'Add Bank Account', [], 30, ['icon' => 'store']);
        }
        
        if ($this->canAccessMenuItem('Taxes', 'create-admin24-portal-taxes')) {
            $menu->route('portal.admin24.showtaxes', 'Add TAX Code', [], 40, ['icon' => 'airline_seat_recline_extra']);
        }
        
        if ($this->canAccessMenuItem('Payments', 'create-admin24-portal-payments')) {
            $menu->route('portal.admin24.showpayments', 'Make a Payment', [], 50, ['icon' => 'local_taxi']);
        }
    }
}
