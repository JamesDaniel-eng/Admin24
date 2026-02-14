<?php

namespace Modules\Admin24\Listeners;

use App\Events\Menu\PortalCreated as Event;
use App\Traits\Permissions;

class PortalMenu {

    use Permissions;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */

    public function handle(Event $event) {        
        $event->menu->removeByTitle('Invoices');
        $event->menu->removeByTitle('Payments');
        
        // Build Client's menu
        if (user()->hasPermission('read-admin24-portal-customers')) {
            $event->menu->dropdown('Income', function ($sub) {
            $sub->route('portal.admin24.showcustomers', 'Customers', [], 1, ['icon' => '']);
            $sub->route('portal.admin24.showcustomerinvoices', 'Invoices', [], 2, ['icon' => '']);
            $sub->route('portal.admin24.showcustomerreceipts', 'Receipts', [], 3, ['icon' => '']);
            $sub->route('portal.admin24.showincomeaccounts', 'Income Accounts', [], 4, ['icon' => '']);
            }, 10, [
                'title' => 'Income',
                'icon' => 'point_of_sale',
            ]);
        }

        if (user()->hasPermission('read-admin24-portal-expenses')) {
            $event->menu->dropdown('Expenses', function ($sub) {
            $sub->route('portal.invoices.index', 'Admin24 Plan', [], 1, ['icon' => '']);
            $sub->route('portal.admin24.showbills', 'Bills', [], 2, ['icon' => '']);
            $sub->route('portal.admin24.showvendors', 'Vendors', [], 3, ['icon' => '']);
            $sub->route('portal.admin24.showexpenseaccounts', 'Expense Accounts', [], 4, ['icon' => '']);
            }, 11, [
                'title' => 'Expenses',
                'icon' => 'credit_score',
            ]);
        }
        
        if (user()->hasPermission('read-admin24-portal-assets')) {
            $event->menu->dropdown('Assets', function ($sub) {
            $sub->route('portal.admin24.showemployees', 'Employees', [], 1, ['icon' => '']);
            $sub->route('portal.admin24.showassets', 'Assets', [], 2, ['icon' => '']);
            $sub->route('portal.admin24.showinventory', 'Inventory', [], 3, ['icon' => '']);
            $sub->route('portal.admin24.show-ledgers-journals', 'Ledgers & Journals', [], 4, ['icon' => '']);
            }, 12, [
                'title' => 'Assets',
                'icon' => 'account_tree',
            ]);
        }

        if (user()->hasPermission('read-admin24-portal-banking')) {
            $event->menu->dropdown('Banking', function ($sub) {
            $sub->route('portal.admin24.showaccounts', 'Accounts', [], 1, ['icon' => '']);
            $sub->route('portal.admin24.showtransactions', 'Transactions', [], 2, ['icon' => '']);
            $sub->route('portal.admin24.showtreconciliations', 'Reconciliations', [], 3, ['icon' => '']);
            }, 14, [
                'title' => 'Banking',
                'icon' => 'account_balance',
            ]);
        }

        if (user()->hasPermission('read-admin24-portal-taxes')) {
            $event->menu->dropdown('Taxes', function ($sub) {
            $sub->route('portal.admin24.showtaxes', 'Taxes', [], 1, ['icon' => '']);
            $sub->route('portal.admin24.showtaxbills', 'Tax Bills', [], 2, ['icon' => '']);
            $sub->route('portal.admin24.showtaxfillings', 'Tax Filling', [], 3, ['icon' => '']);
            }, 16, [
                'title' => 'Taxes',
                'icon' => 'percent',
            ]);
        }

        if (user()->hasPermission('read-admin24-portal-payments')) {
            $event->menu->dropdown('Payments', function ($sub) {
            $sub->route('portal.admin24.showpayments', 'Payments', [], 1, ['icon' => '']);
            $sub->route('portal.admin24.payinvoices', 'Pay Invoices', [], 2, ['icon' => '']);
            $sub->route('portal.admin24.paybills', 'Pay Bills', [], 3, ['icon' => '']);
            $sub->route('portal.admin24.paytaxes', 'Pay Taxes', [], 4, ['icon' => '']);
            }, 18, [
                'title' => 'Payments',
                'icon' => 'payments',
            ]);
        }
    }
}