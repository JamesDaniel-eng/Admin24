<?php

namespace Modules\Admin24\Observers\Tweaks\Inventory;

use App\Abstracts\Observer;
use App\Models\Common\Item as CoreItem;
use Modules\Inventory\Models\Common\Item as InventoryItem;

class Items extends Observer
{
    public function retrieved(InventoryItem $item): void
    {
        $items = CoreItem::where('created_from', 'inventory::ui');
    }
}