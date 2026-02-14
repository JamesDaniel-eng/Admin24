<?php

namespace Modules\Inventory\Http\Controllers;

use App\Traits\Currencies;
use App\Abstracts\Http\Controller;
use App\Models\Setting\Currency;
use App\Models\Common\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Inventory\Traits\Barcode;
use Modules\Inventory\Traits\Inventory;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Models\Common\Item as CoreItem;
use Modules\Inventory\Jobs\TransferOrders\CreateTransferOrder;
use Modules\DoubleEntry\Jobs\Journal\CreateJournalEntry;
use Modules\DoubleEntry\Traits\Journal;

class Pot extends Controller
{
    use Barcode, Currencies, Inventory, Journal;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $currency = Currency::where('code', setting('default.currency'))->first();
        $warehouses = Warehouse::enabled()->pluck('name', 'id');
        $items = CoreItem::with('inventory', 'category', 'media', 'inventories')
            ->whereHas('category', function ($query) {
                $query->where('name', '!=', 'Utilities');
            })
            ->collect();
        return view('inventory::pot.index', compact('currency', 'warehouses', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $currency = Currency::where('code', setting('default.currency'))->first();
        $warehouses = Warehouse::enabled()->pluck('name', 'id');
        $items = CoreItem::with('inventory', 'category', 'media', 'inventories')
            ->whereHas('category', function ($query) {
                $query->where('name', '!=', 'Utilities');
            })
            ->collect();
        
        // Fetch accounts from Chart of Accounts with code and name
        $accounts = \Modules\DoubleEntry\Models\Account::where('enabled', 1)
            ->orderBy('code')
            ->get()
            ->mapWithKeys(function ($account) {
                $accountName = trans($account->name);
                return [$account->id => $account->code . ' - ' . $accountName];
            });
        
        // Get flow type from query parameter (create or return)
        $flow = $request->get('flow', 'create');
        
        return view('inventory::pot.show', compact('currency', 'warehouses', 'items', 'accounts', 'flow'));
    }

    /**
     * Get items for a specific warehouse
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWarehouseItems(Request $request)
    {
        $warehouseId = $request->get('warehouse_id');
        
        $items = CoreItem::with('inventory', 'category', 'media', 'inventories', 'de_expense_account')
            ->whereHas('category', function ($query) {
                $query->where('name', '!=', 'Utilities');
            })
            ->get()
            ->map(function ($item) use ($warehouseId) {
                $inventory = $item->inventories()
                    ->where('warehouse_id', $warehouseId)
                    ->first();
                
                // Get the expense account ID for this item
                $expenseAccountId = $item->de_expense_account?->account_id;
                
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'code' => $item->sku,
                    'price' => $item->purchase_price ?? 0,
                    'quantity' => $inventory ? $inventory->opening_stock : 0,
                    'expense_account_id' => $expenseAccountId,
                ];
            });
        
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            // Parse items from JSON if submitted as form field
            $items = $request->has('items_json') 
                ? json_decode($request->input('items_json'), true) 
                : $request->input('items', []);

            $flowType = $request->input('flow_type', 'create');

            \Log::info('PoT Store: Items received', ['items' => $items, 'flow' => $flowType]);
            \Log::info('PoT Store: Request data', $request->except(['items_json']));

            // Build validation rules based on flow type
            $validationRules = [
                'date' => 'required|date',
                'source_warehouse_id' => 'required|exists:inventory_warehouses,id',
                'destination_warehouse_id' => 'required|exists:inventory_warehouses,id',
                'total_amount' => 'required|numeric|min:0',
            ];

            // For create flow: require credit account only
            // For return flow: require debit account only
            if ($flowType === 'create') {
                $validationRules['credit_account_id'] = 'required|exists:double_entry_accounts,id';
            } else {
                $validationRules['debit_account_id'] = 'required|exists:double_entry_accounts,id';
            }

            // Validate the incoming request
            $validated = $request->validate($validationRules);

            // Manually validate items
            if (empty($items) || !is_array($items)) {
                throw new \Exception('No items provided for transfer');
            }

            if (!is_array($items[0]) || empty($items[0]['item_id'])) {
                throw new \Exception('Invalid items format');
            }

            // Validate source and destination are different
            if ($validated['source_warehouse_id'] === $validated['destination_warehouse_id']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Source and destination warehouses cannot be the same'
                ], 422);
            }

            // Validate all items have required fields
            foreach ($items as $item) {
                if (empty($item['item_id']) || empty($item['item_quantity'])) {
                    throw new \Exception('Each item must have item_id and item_quantity');
                }
            }

            // Validate that all items exist in the source warehouse
            $missing_items = [];
            $sourceWarehouseId = $validated['source_warehouse_id'];
            
            foreach ($items as $item) {
                // Check if item exists in source warehouse using InventoryItem model
                $sourceInventory = \Modules\Inventory\Models\Item::where('warehouse_id', $sourceWarehouseId)
                    ->where('item_id', $item['item_id'])
                    ->first();
                
                if (!$sourceInventory) {
                    // Use item_name from the request if available, otherwise fallback to ID
                    $itemName = $item['item_name'] ?? ('Item ID ' . $item['item_id']);
                    $missing_items[] = $itemName;
                }
            }

            // If any items are missing in the source warehouse, return error
            if (!empty($missing_items)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The following items do not exist in the source warehouse and must be purchased first: ' . implode(', ', $missing_items)
                ], 422);
            }

            // Create Transfer Order with proper item structure
            $formattedItems = array_map(function($item) {
                return [
                    'item_id' => $item['item_id'],
                    'item_quantity' => $item['item_quantity'],
                    'transfer_quantity' => $item['transfer_quantity'] ?? $item['item_quantity'],
                ];
            }, $items);

            $nextTransferOrderNumber = $this->getNextTransferOrderNumber();

            $transferOrderRequest = new Request([
                'company_id' => company_id(),
                'transfer_order' => $nextTransferOrderNumber,
                'transfer_order_number' => $nextTransferOrderNumber,
                'date' => $validated['date'],
                'source_warehouse_id' => $validated['source_warehouse_id'],
                'destination_warehouse_id' => $validated['destination_warehouse_id'],
                'reason' => 'Point of Transfer - Inventory Movement',
                'created_from' => 'inventory::pot',
                'created_by' => auth()->id(),
                'items' => $formattedItems,
            ]);

            \Log::info('PoT Store: Creating transfer order with items', ['items' => $formattedItems]);

            $transferOrder = $this->dispatch(new CreateTransferOrder($transferOrderRequest));

            \Log::info('PoT Store: Transfer order created', ['id' => $transferOrder->id]);

            // Create Journal Entry based on flow type
            // For CREATE flow: Credit Account is user-selected, Debit is each item's expense account
            // For RETURN flow: Debit Account is user-selected, Credit is each item's expense account
            
            $journalItems = [];
            $itemsWithoutExpenseAccount = [];
            
            // Fetch items from DB with expense accounts
            $dbItems = Item::whereIn('id', array_column($items, 'item_id'))
                ->with('de_expense_account')
                ->get();
            
            // Check if all items have expense accounts
            foreach ($dbItems as $dbItem) {
                if (!$dbItem->de_expense_account || !$dbItem->de_expense_account->account_id) {
                    $itemsWithoutExpenseAccount[] = $dbItem->name;
                }
            }
            
            // If any items are missing expense accounts, return error
            if (!empty($itemsWithoutExpenseAccount)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The following items do not have an expense account configured: ' . implode(', ', $itemsWithoutExpenseAccount) . '. Please configure expense accounts for these items before proceeding.'
                ], 422);
            }
            
            if ($flowType === 'create') {
                // Create flow: credit is user-selected, debit is each item's expense account
                foreach ($dbItems as $dbItem) {
                    $itemAmount = 0;
                    foreach ($items as $cartItem) {
                        if ($cartItem['item_id'] == $dbItem->id) {
                            $itemAmount = ($cartItem['item_price'] ?? 0) * $cartItem['item_quantity'];
                            break;
                        }
                    }
                    
                    if ($itemAmount > 0) {
                        // Debit from each item's expense account
                        $journalItems[] = [
                            'account_id' => $dbItem->de_expense_account->account_id,
                            'debit' => $itemAmount,
                            'notes' => 'Inventory Transfer - Debit from ' . $dbItem->name
                        ];
                    }
                }
                
                // Credit to user-selected account
                $journalItems[] = [
                    'account_id' => $validated['credit_account_id'],
                    'credit' => $validated['total_amount'],
                    'notes' => 'Inventory Transfer - Credit Account'
                ];
            } else {
                // Return flow: debit is user-selected, credit is each item's expense account
                $journalItems[] = [
                    'account_id' => $validated['debit_account_id'],
                    'debit' => $validated['total_amount'],
                    'notes' => 'Inventory Return - Debit Account'
                ];
                
                // Credit to each item's expense account
                foreach ($dbItems as $dbItem) {
                    $itemAmount = 0;
                    foreach ($items as $cartItem) {
                        if ($cartItem['item_id'] == $dbItem->id) {
                            $itemAmount = ($cartItem['item_price'] ?? 0) * $cartItem['item_quantity'];
                            break;
                        }
                    }
                    
                    if ($itemAmount > 0) {
                        $journalItems[] = [
                            'account_id' => $dbItem->de_expense_account->account_id,
                            'credit' => $itemAmount,
                            'notes' => 'Inventory Return - Credit to ' . $dbItem->name
                        ];
                    }
                }
            }
            
            $journalEntryRequest = new Request([
                'company_id' => company_id(),
                'journal_number' => $this->getNextJournalNumber(),
                'reference' => 'TRANSFER_' . $transferOrder->transfer_order_number,
                'description' => ($flowType === 'create' ? 'Transfer Order' : 'Return Transfer') . ': ' . $transferOrder->transfer_order_number,
                'paid_at' => $validated['date'],
                'source' => 'transfer_order',
                'items' => $journalItems,
            ]);

            $journalEntry = $this->dispatch(new CreateJournalEntry($journalEntryRequest));

            return response()->json([
                'success' => true,
                'message' => 'Transfer order created successfully',
                'transfer_order_number' => $transferOrder->transfer_order_number,
                'journal_entry_number' => $journalEntry->journal_number,
                'redirect_url' => route('inventory.transfer-orders.show', $transferOrder->id)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Transfer Order Validation Error:', $e->errors());
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Transfer Order Creation Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create transfer order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('inventory::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('inventory::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
