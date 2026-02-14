<?php

namespace Modules\Admin24\Imports;

use App\Abstracts\Import;
use App\Models\Common\Item;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Modules\Inventory\Models\History;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Traits\Inventory as TOrder;
use Modules\Inventory\Models\Item as InventoryItem;
use Modules\Inventory\Models\TransferOrder as Model;
use Modules\Inventory\Http\Requests\TransferOrder as Request;
use Modules\Inventory\Models\TransferOrderItem as ModelItem;
use Modules\Inventory\Models\TransferOrderHistory as ModelHistory;
use Modules\Admin24\Models\Admin24PurchasePriceHistory as PriceHistory;

class TransferOrdersImport extends Import implements WithHeadingRow, ToModel
{
    use TOrder;

    /**
     * Map of date &rarr; TransferOrder instance
     *
     * @var Model[]
     */
    protected $ordersByDate = [];

    public $to_item;
    public $source_inventory_item;
    public $destination_inventory_item;

    public function model(array $row)
    {
        $row['date'] = Carbon::instance($row['date']);
        $row['sale_price'] = 0;
        $this->to_item = $row;
        $dateString = $row['date']->toDateString();

        // Only increment when first creating that day's order
        if (! isset($this->ordersByDate[$dateString])) {
            $this->increaseNextTransferOrderNumber();
        }

        return \DB::transaction(function () use ($dateString) {
            $user = user_id();
            $company_id = company_id();

            // 1) Create or reuse TransferOrder for this date
            if (! isset($this->ordersByDate[$dateString])) {
                $orderData = [
                    'company_id'               => $company_id,
                    'date'                     => $dateString,
                    'transfer_order'           => $this->to_item['transfer_order'],
                    'reason'                   => 'Production Consumption.',
                    'source_warehouse_id'      => $this->to_item['source_warehouse_id'],
                    'destination_warehouse_id' => $this->to_item['destination_warehouse_id'],
                    'created_from'             => 'admin24::imports',
                    'created_by'               => $user,
                    'transfer_order_number'    => $this->getNextTransferOrderNumber(),
                    'status'                   => 'transferred',
                ];

                $order = Model::create($orderData);
                $this->ordersByDate[$dateString] = $order;

                // Record order-level history once
                ModelHistory::create([
                    'company_id'        => $company_id,
                    'created_by'        => $user,
                    'transfer_order_id' => $order->id,
                    'status'            => 'transferred',
                    'created_from'      => 'admin24::imports',
                ]);
            }

            $transferOrder = $this->ordersByDate[$dateString];
            $orderId = $transferOrder->id;

            // 2) Find or create the core Item
            $item = Item::firstOrCreate(
                ['name' => $this->to_item['item_name'], 'company_id' => $company_id],
                [
                    'type'           => 'product',
                    'sale_price'     => 0,
                    'purchase_price' => $this->to_item['purchase_price'],
                    'enabled'        => 1,
                    'created_from'   => 'admin24::imports',
                    'created_by'     => $user,
                ]
            );
            $itemId = $item->id;

            // 3) Update inventory items
            $srcInv = InventoryItem::firstOrCreate([
                'company_id'   => $company_id,
                'warehouse_id' => $this->to_item['source_warehouse_id'],
                'item_id'      => $itemId,
            ], ['opening_stock' => 0, 'created_from' => 'admin24::imports', 'created_by' => $user]);

            $dstInv = InventoryItem::firstOrCreate([
                'company_id'   => $company_id,
                'warehouse_id' => $this->to_item['destination_warehouse_id'],
                'item_id'      => $itemId,
            ], ['opening_stock' => 0, 'created_from' => 'admin24::imports', 'created_by' => $user]);

            $srcInv->decrement('opening_stock', $this->to_item['transfer_quantity']);
            $dstInv->increment('opening_stock', $this->to_item['transfer_quantity']);

            // 4) Create transfer order item
            $transferItem = ModelItem::create([
                'company_id'        => $company_id,
                'transfer_order_id' => $orderId,
                'item_id'           => $itemId,
                'item_quantity'     => $srcInv->opening_stock,
                'transfer_quantity' => $this->to_item['transfer_quantity'],
                'created_from'      => 'admin24::imports',
                'created_by'        => $user,
            ]);

            // 5) Warehouse history entries
            foreach ([
                ['warehouse_id' => $this->to_item['source_warehouse_id'],      'quantity' => $this->to_item['transfer_quantity']],
                ['warehouse_id' => $this->to_item['destination_warehouse_id'], 'quantity' => $this->to_item['transfer_quantity']],
            ] as $h) {
                History::create([
                    'company_id'   => $company_id,
                    'user_id'      => $user,
                    'item_id'      => $itemId,
                    'type_id'      => $orderId,
                    'type_type'    => get_class($transferOrder),
                    'warehouse_id' => $h['warehouse_id'],
                    'quantity'     => $h['quantity'],
                    'created_from' => 'admin24::imports',
                    'created_by'   => $user,
                ]);
            }

            // 6) Price history
            PriceHistory::create([
                'company_id'    => $company_id,
                'user_id'       => $user,
                'item_id'       => $itemId,
                'purchase_price'=> (int) $this->to_item['purchase_price'],
                'price_date'    => $dateString,
                'created_at'    => $dateString,
            ]);

            return $transferItem;
        });
    }

    public function map($row): array
    {
        $company_id = company_id();
        $user       = user_id(); 
        $row['company_id']               = $company_id;       
        $row['date'] = Carbon::instance(Date::excelToDateTimeObject($row['date']));
        $row['transfer_order'] = 'Consumption: ' . $row['transfer_order'];        
        $row['reason']                   = 'Production sales.';
        $row['source_warehouse_id']      = $this->getWarehouseId($row['source_warehouse']);
        $row['destination_warehouse_id'] = $this->getWarehouseId($row['destination_warehouse']);
        $row['created_from']             = 'admin24::imports';
        $row['created_by']               = $user;
        $row['transfer_order_number']    = $this->getNextTransferOrderNumber();
        $row['status']                   = 'transferred';

        return parent::map($row);
    }

    private function getWarehouseId(string $name): int
    {
        $warehouse = Warehouse::where('name', $name)->first();
        if ($warehouse) {
            return $warehouse->id;
        }
        return \DB::table('inventory_warehouses')->insertGetId([
            'company_id'   => company_id(),
            'name'         => $name,
            'enabled'      => 1,
            'created_from' => 'admin24::imports',
        ]);
    }

    public function rules(): array
    {
        return (new Request())->rules();
    }
}