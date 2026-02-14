<?php

namespace Modules\Inventory\Http\ViewComposers;

use App\Traits\Modules;
use Illuminate\View\View;

class DocumentItemButton
{
    use Modules;

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if ($this->moduleIsDisabled('inventory')) {
            return;
        }

        $data = $view->getData();

        $search_url = route('inventory.items.index');
        $search_list_key = [
            'value',
            'inventory.barcode',
        ];

        $items = \Modules\Inventory\Models\Common\Item::with('inventory', 'category', 'media', 'inventories')
            ->whereNotNull($data['price'])
            ->enabled()
            ->orderBy('name')
            ->take(setting('default.select_limit'))
            ->get();

        $view->with([
            'searchUrl' => $search_url,
            'searchListKey' => $search_list_key,
            'items' => $items,
        ]);
    }
}
