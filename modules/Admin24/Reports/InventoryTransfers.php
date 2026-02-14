<?php

namespace Modules\Admin24\Reports;

use Akaunting\Apexcharts\Chart as Apexcharts;
use Plank\Mediable\MediableCollection as Collection;
use App\Abstracts\Report;
use App\Utilities\Date;
use App\Models\Document\DocumentItem;
use Modules\Inventory\Models\Item as InventoryItem;
use App\Models\Common\Item as CoreItem;
use Modules\Inventory\Models\History;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Models\TransferOrder;
use Modules\Inventory\Models\TransferOrderItem as TransferItem;

class InventoryTransfers extends Report
{
    public $default_name = 'admin24::reports.inventory_transfers';

    public $category = 'admin24::general.name';

    public $icon = 'precision_manufacturing';

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

        $this->t_os = $this->getOrders();

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
                'unit_price' => trans_choice('admin24::reports.unit_price', 2),
                'portions' => trans_choice('admin24::reports.portions', 2),
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
                        'unit_price' => trans_choice('admin24::reports.unit_price', 2),
                        'portions' => trans_choice('admin24::reports.portions', 2),
                        'total' => trans_choice('admin24::reports.total', 2),
                    ];
                    $this->row_values[$table_key][$id] = [
                        'date' => '',
                        'name' => '',
                        'transfer_quantity' => '',
                        'purchase_price' => 0,
                        'portions' => '',
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
                    'unit_price' => trans_choice('admin24::reports.unit_price', 2),
                    'portions' => trans_choice('admin24::reports.portions', 2),
                    'total' => trans_choice('admin24::reports.total', 2),
                ];
            }
        }
    }

    public function setData()
    {
        $total_items = $this->getTransferItems();
        $orders = $this->getOrders();        
        $t_items = new Collection();

        if (! $total_items || ! $orders) {
            return;
        }

            
        foreach($total_items as $items){
            foreach($items as $item){
                $t_items->push($item);
            }
        }

        $g_t_items = $t_items->groupBy('item_id');
        foreach($g_t_items as $id => $t_itms){
            $quantity = 0;
            $t_o_i = [];
            foreach($t_itms as $t_itm){
                $t_o_i = $t_itm;
                if($t_itm->item_id === $id){
                    $quantity += $t_itm->transfer_quantity;
                }
            }
            $core_item = CoreItem::where('id', $id)->first();
            $inventory_item = InventoryItem::where('item_id', $id)->first();

            $t_value = $quantity * $core_item->sale_price;
            
            $this->row_values['item'][$id] = [                        
                'date' => Date::parse($t_itm->created_at)->toDateString(),
                'name' => $core_item->name,
                'transfer_quantity' => $quantity." ".$inventory_item->unit,
                'unit_price' => $core_item->sale_price,
                'portions' => 0,
                'total' => $t_value,
            ];

        }
    } 

    public function getItems()
    {
        $this->collected_items = new Collection();
        $orders_items = $this->getTransferItems();
        $_t_items = [];

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

    public function getOrders(){
        $orders = $this->applyFilters(TransferOrder::where('destination_warehouse_id', $this->destination), ['date_field' => 'created_at'])
                       ->where('status', 'transferred')
                       ->with('transfer_order_items')
                       ->get();

        return $orders;
    }

    public function getTransferItems(){
        $transfer_items = $this->getOrders()->pluck('transfer_order_items');

        return $transfer_items;
    }
}
