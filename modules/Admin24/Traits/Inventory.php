<?php

namespace Modules\Admin24\Traits;

use File;
use Image;
use App\Utilities\Date;
use App\Models\Common\Item;
use Modules\Inventory\Models\Item as InventoryItem;
use App\Models\Common\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Inventory\Models\TransferOrder;
use Modules\Admin24\Models\Warehouse;
use Modules\Inventory\Jobs\Warehouses\CreateWarehouse;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

trait Inventory
{

    /**
     * Generate next transfer order number
     *
     * @return string
     */
    public function getNextTransferOrderNumber($row)
    {
        $prefix = setting('inventory.transfer_order_prefix', 'TO-');
        $next = setting('inventory.transfer_order_next', '1');
        $digit = setting('inventory.transfer_order_digit', '5');

        $number = $prefix . str_pad($next, $digit, '0', STR_PAD_LEFT);

        return $number;
    }

    public function getTransferTitle($row){
        $title = $row['transfer_order_name'] . " " . $row['inventory_item_name'];

        return $title;
    }

    public function getSourceId($row){
        $item_id = Item::where('name', $row['inventory_item_name'])->first()->id;
        $sourceID = InventoryItem::where('item_id', $item_id)->first()->warehouse_id;

        return $sourceID;
    }

    public function getDestinationId($row){       
        $destinationID = Item::where('name', $row['destination_warehouse'])->first()->id;

        return $destinationID;
    }

    public function setDate($row){
        $date = Carbon::today()->format('Y-m-d');

        return $date;
    }

    public function getItem($row){       
        $item = Item::where('name', $row['inventory_item_name'])->first()->id;

        return $destinationID;
    }

}
