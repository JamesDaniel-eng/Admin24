<?php

namespace Modules\CompositeItems\Http\ViewComposers;

use App\Traits\Modules;
use Illuminate\View\View;
use App\Models\Common\Item;
use Illuminate\Support\Str;
use Modules\CompositeItems\Models\DocumentItem as CompDocumentItem;

class DocumentItem
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
        // Check if CompositeItems module is enabled before proceeding
        if (!$this->moduleIsEnabled('composite-items')) {
            return;
        }

        $request = request();

        // Document type'ını belirle (Inventory modülü pattern'i)
        $inventory_type = config('type.document.' . Str::singular((string) $request->segment(3)) . '.inventory_stock_action');
        $is_income = $request->segment(1) == 'sales' || $request->routeIs('invoices.*');
        $price_field = $is_income ? 'sale_price' : 'purchase_price';

        $items = Item::with('composite_item', 'inventory')->get();

        // Inventory modülü kontrolü ve warehouse bilgileri
        $inventory_enabled = $this->moduleIsEnabled('inventory');
        $warehouses = [];

        if ($inventory_enabled) {
            $warehouses = \Modules\Inventory\Models\Warehouse::enabled()->get()->map(function ($warehouse) {
                return [
                    'value' => $warehouse->id,
                    'label' => $warehouse->name,
                ];
            })->toArray();
        }

        $item_selected = [];
        $composite_items_data = [];
        $item_default_composite_items = [];
        $item_selected_composite_items = [];

        if ($request->routeIs('invoices.edit') || $request->routeIs('bills.edit')) {
            $document = $request->route(Str::singular((string) $request->segment(3)));

            foreach ($document->items as $key => $item) {
                $composite_items = CompDocumentItem::where('document_item_id', $item->id)->get();

                // Default composite items verilerini hazırla
                $composite_items_formatted = [];

                foreach ($composite_items as $composite_item) {
                    $related_item = $composite_item->item;
                    $composite_items_formatted[] = [
                        'id' => $composite_item->id,
                        'item_id' => (string) $composite_item->item_id,
                        'item_name' => $related_item ? $related_item->name : '',
                        'quantity' => $composite_item->quantity ?? 1,
                        'price' => $related_item ? $related_item->{$price_field} : 0,
                        'amount' => ($composite_item->quantity ?? 1) * ($related_item ? $related_item->{$price_field} : 0),
                        'warehouse_id' => (string) ($composite_item->warehouse_id ?? ''),
                    ];
                }

                $item_selected_composite_items[$item->item_id][$key] = $composite_items_formatted;
            }
        }

        foreach ($items as $item) {
            $comp_item = $item->composite_item;

            if (! $comp_item || ! $comp_item->exists) {
                continue;
            }

            $composite_items = $comp_item->composite_items;

            // Mevcut yapıyı koruyalım
            foreach ($composite_items as $composite_item) {
                $item_selected[$item->id][] = [
                    'id' => $composite_item->id,
                    'item_id' => $composite_item->item_id,
                    'name' => $composite_item->name,
                    'sku' => $composite_item->sku,
                    'barcode' => $composite_item->barcode,
                    'unit' => $composite_item->unit,
                    'sale_price' => $composite_item->sale_price,
                    'purchase_price' => $composite_item->purchase_price,
                ];
            }

            // Default composite items verilerini hazırla
            $composite_items_formatted = [];

            foreach ($composite_items as $composite_item) {
                $related_item = $composite_item->item;
                $composite_items_formatted[] = [
                    'id' => $composite_item->id,
                    'item_id' => $composite_item->item_id,
                    'item_name' => $related_item ? $related_item->name : '',
                    'item_sku' => $related_item ? $related_item->sku : '',
                    'quantity' => $composite_item->quantity ?? 1,
                    'price' => $related_item ? $related_item->{$price_field} : 0,
                    'unit' => $related_item ? $related_item->unit : '',
                    'warehouse_id' => $composite_item->warehouse_id ?? null,
                ];
            }

            $item_default_composite_items[$item->id] = $composite_items_formatted;
        }

        $items = Item::with('inventory')->whereDoesntHave('composite_item')->get();

        if ($inventory_enabled) {
            $warehouse_ids = $items->pluck('inventory.warehouse_id')->unique()->toArray();

            $warehouses = \Modules\Inventory\Models\Warehouse::whereIn('id', $warehouse_ids)->enabled()->get()->pluck('name', 'id');
        }

        $view->getFactory()->startPush('item_custom_fields', view('composite-items::partials.input_document_item', compact('items', 'warehouses', 'inventory_enabled')));

        $view->getFactory()->startPush('body_scripts', view('composite-items::partials.body_script'));

        $view->getFactory()->startPush('scripts', view('composite-items::partials.script', compact('item_selected', 'item_default_composite_items', 'item_selected_composite_items', 'inventory_enabled', 'warehouses')));

        $view->getFactory()->startPush(
            'body_end',
            '<div id="composite-items-vue-entrypoint"><component v-bind:is="component"></component></div>'
        );
    }
}
