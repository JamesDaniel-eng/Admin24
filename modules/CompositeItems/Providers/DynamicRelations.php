<?php

namespace Modules\CompositeItems\Providers;

use App\Models\Common\Item;
use Illuminate\Support\ServiceProvider;

class DynamicRelations extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Item::resolveRelationUsing('composite_item', function ($item) {
            return $item->belongsTo('Modules\CompositeItems\Models\CompositeItem', 'id', 'item_id');
        });
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
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
