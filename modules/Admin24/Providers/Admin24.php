<?php

namespace Modules\Admin24\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Common\Company;
use Modules\Inventory\Models\TransferOrder;
use Modules\Inventory\Models\Common\Item as Items;

class Admin24 extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register View Composers
        View::composer(['components.layouts.auth.footer'], 'Modules\Admin24\Http\ViewComposers\AuthFooter');
        View::composer(['components.layouts.admin.footer'], 'Modules\Admin24\Http\ViewComposers\Footer');
        View::composer(['components.layouts.portal.footer'], 'Modules\Admin24\Http\ViewComposers\Footer');
        View::composer(['components.layouts.portal.menu'], 'Modules\Admin24\Http\ViewComposers\PortalMenu');
        View::composer(['components.layouts.portal'], 'Modules\Admin24\Http\ViewComposers\PortalLayout');
        View::composer(['portal.dashboard.index'], 'Modules\Admin24\Http\ViewComposers\Portal');
        View::composer(['inventory::transfer-orders.index'], 'Modules\Admin24\Http\ViewComposers\InventoryTransferOrders');
        View::composer(['inventory::transfer-orders.show'], 'Modules\Admin24\Http\ViewComposers\InventoryTransferOrder');
        View::composer(['inventory::transfer-orders.print'], 'Modules\Admin24\Http\ViewComposers\InventoryTransferOrderPrint');

        // Register Observers
        TransferOrder::observe('Modules\Admin24\Observers\Tweaks\Inventory\TransferOrder');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
