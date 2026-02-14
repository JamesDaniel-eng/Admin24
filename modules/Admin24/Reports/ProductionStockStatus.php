<?php

namespace Modules\Admin24\Reports;

use Akaunting\Apexcharts\Chart as Apexcharts;
use Plank\Mediable\MediableCollection as Collection;
use App\Abstracts\Report;
use App\Utilities\Date;
use App\Models\Document\DocumentItem;
use Modules\Inventory\Models\Item as InventoryItem;
use App\Models\Common\Item as CoreItem;
use Modules\Admin24\Models\Admin24PurchasePriceHistory as PriceHistory;
use Modules\Admin24\Models\Admin24Quantities as Quantities;
use Modules\Inventory\Models\History;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Models\TransferOrder;
use Modules\Inventory\Models\TransferOrderItem as TransferItem;

class ProductionStockStatus extends Report
{
    public $default_name = 'admin24::reports.production_stock_status';

    public $category = 'admin24::general.name';

    public $icon = 'warehouse';

    public $type = 'summary';

    public $chart = false;

    public $has_money = true;

    public $destination;
    public $t_os;
    public $collected_items;
    public $transferred_items;
    public $items;
    public $total_items;
    public $total_stock;
    public $total_product;


    public function setViews()
    {
        parent::setViews();
        $this->views['summary'] = 'admin24::components.reports.summary';
        $this->views['summary.table'] = 'admin24::partials.reports.summary.table';
        $this->views['summary.table.header'] = 'admin24::partials.reports.summary.table.header';
        $this->views['summary.table.body'] = 'admin24::partials.reports.summary.table.body';
        $this->views['summary.table.row'] = 'admin24::partials.reports.summary.table.row';
        $this->views['summary.table.footer'] = 'admin24::partials.reports.summary.table.footer';
    }

    /**
     * Create the static data table
     * to display the data for the selected
     * period.
     */
    public function setTables()
    {
        $production = Warehouse::firstWhere('name', 'Production');
        $this->destination = $production->id;

        $this->tables = [
            'item' => trans_choice('admin24::reports.transferred_items', 2),
        ];
    }

    /**
     * Set the rows
     * in the data display table.
     * 
     */
    public function setRows()
    {
        $rows = [];

        $items = $this->getItems();

        if (! $items) {
            return;
        }

        foreach ($items as $id => $item) {
            $rows[$id] = [                        
                'date' => trans_choice('admin24::reports.date', 2),
                'name' => trans_choice('admin24::reports.item_name', 2),
                'transfer_quantity' => trans_choice('admin24::reports.transfer_quantity', 2),
                'unit_price' => trans_choice('admin24::reports.purchase_price', 2),
                'quantities' => trans_choice('admin24::reports.prod_quantities', 2),
                'total' => trans_choice('admin24::reports.total', 2),
            ];
        }

        $this->setRowNamesAndValues($rows);
    }

    /**
     * Sets the rown names and values
     * in the data display table.
     * 
     */
    public function setRowNamesAndValues($rows)
    {
        $nodes = [];

        foreach ($this->dates as $date) {
            foreach ($this->tables as $table_key => $table_name) {
                foreach ($rows as $id => $name) {
                    $this->row_names[$table_key][$id] = [                        
                        'date' => trans_choice('admin24::reports.date', 2),
                        'name' => trans_choice('admin24::reports.item_name', 2),
                        'transfer_quantity' => trans_choice('admin24::reports.transfer_quantity', 2),
                        'unit_price' => trans_choice('admin24::reports.purchase_price', 2),
                        'quantities' => trans_choice('admin24::reports.prod_quantities', 2),
                        'total' => trans_choice('admin24::reports.total', 2),
                    ];
                    $this->row_values[$table_key][$id] = [
                        'date' => '',
                        'name' => '',
                        'transfer_quantity' => '',
                        'purchase_price' => 0,
                        'quantities' => '',
                        'total' => 0,
                    ];

                    $nodes[$id] = null;
                }
            }
        }

        $this->setTreeNodes($nodes);
    }

    public function setTreeNodes($nodes)
    {
        foreach ($this->tables as $table_key => $table_name) {
            foreach ($nodes as $id => $node) {
                $this->row_tree_nodes[$table_key][$id] = [                        
                    'date' => trans_choice('admin24::reports.date', 2),
                    'name' => trans_choice('admin24::reports.item_name', 2),
                    'transfer_quantity' => trans_choice('admin24::reports.transfer_quantity', 2),
                    'unit_price' => trans_choice('admin24::reports.purchase_price', 2),
                    'quantities' => trans_choice('admin24::reports.prod_quantities', 2),
                    'total' => trans_choice('admin24::reports.total', 2),
                ];
            }
        }
    }

    public function setData()
    {
        $total_items = $this->getTransferItems();      
        $t_items = new Collection();

        if (! $total_items) {
            return;
        }
            
        foreach($total_items as $items){
            foreach($items as $item){
                $t_items->push($item);
            }
        }

        $g_t_items = $t_items->groupBy('item_id');

        foreach($g_t_items as $id => $t_itms){
            $quantity = $t_value = $total_quantity = 0;
            $core_item = CoreItem::where('id', $id)->first();
            $inventory_item = InventoryItem::where('item_id', $id)->first();

            foreach($t_itms as $t_itm){
                $total = $item_price = 0;
                $t_date = TransferOrder::where('id', $t_itm->transfer_order_id)->first()->date;
                $price_history = PriceHistory::where('item_id', $id)->where('price_date', $t_date)->latest()->first();

                if($t_itm->item_id === $id){
                    $quantity = $t_itm->transfer_quantity;
                    $total_quantity += $quantity;
                    if(empty($price_history)){
                        $item_price = $core_item->purchase_price;
                    } else {
                        $item_price = $price_history->purchase_price;
                    }
                    $total = $quantity * $item_price;
                }

                $t_value += $total;
                $t_o = TransferOrder::where('id', $t_itm->transfer_order_id)->first();
                $prod = Quantities::where('item_id', $id)->first();
                $name = "";
                $qnt = "";

                if(!empty($prod)){
                    $prod_quantity = round((($prod->multiplier / $prod->ratio) * $total_quantity));

                    if($prod_quantity >= 2){
                        $name = $prod->name."s";
                    } else {
                        $name = $prod->name;
                    }
                } else {
                    $prod_quantity = "N/A";
                }

                if(!empty($inventory_item->unit)){
                    if($total_quantity >= 2){
                        $qnt = $inventory_item->unit."s";
                    } else {
                        $qnt = $inventory_item->unit;
                    }
                }

		if(!$core_item){
		    return;
		}

                $this->row_values['item'][$id] = [                        
                    'date' => Date::parse($t_o->date)->toDateString(),
                    'name' => $core_item->name,
                    'transfer_quantity' => $total_quantity." ".$qnt,
                    'purchase_price' => $item_price,
                    'quantities' => $prod_quantity." ".$name,
                    'total' => $t_value,
                ];
            }  
        }
    } 

    public function getItems()
    {
        $this->collected_items = new Collection();
        $orders_items = $this->getTransferItems();

        foreach($orders_items as $transfer_order_item){

            foreach($transfer_order_item as $t_oi){
                $to_items = $t_oi->with('item')->where('id', $t_oi->id)->get()->pluck('item');

                foreach($to_items as $to_item){
                    $this->collected_items->push($to_item);
                }
            }

        }

        $this->items = $this->collected_items->groupBy('id');

        $request = request()->all();

        if ($request) {
            $search = str_replace('"', '', request('search'));

            if ($search) {
                $this->items->where('name', 'like', '%' . $search . '%');
            }
        }

        return $this->items;
    }

    public function getTransferItems(){
        $transfer_items = $this->applyFilters(TransferOrder::where('destination_warehouse_id', $this->destination), 
            ['date_field' => 'date'])
            ->where('status', 'transferred')
            ->with('transfer_order_items')
            ->get()->pluck('transfer_order_items');
        
        return $transfer_items;
    }
}
