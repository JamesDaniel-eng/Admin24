<?php

namespace Modules\Inventory\Listeners;

use DB;
use App\Traits\Modules;
use App\Models\Common\Item;
use App\Models\Document\Document;
use App\Events\Common\SearchStringApplied as Event;
use Modules\Inventory\Models\Item as InventoryItem;

class SearchDocumentItemBarcode
{
    use Modules;

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($this->moduleIsDisabled('inventory')) {
            return;
        }

        return;

        $query = $event->query;

        $model = $query->getModel();

        $search = request()->get('search');

        if (! $search) {
            return $event->query;
        }

        if ($model instanceof Item) {
            if (preg_match('/"([^"]+)"/', $search, $matches)) {
                $new = $matches[1];
            }

            $hasBarcode = InventoryItem::where('barcode', 'like', '%' . $new . '%')->exists();

            if ($hasBarcode) {
                $event->query->orWhereHas('inventory', function ($query) use ($new) {
                    $query->where('barcode', 'like', '%' . $new . '%');
                });

                $event->query->addSelect('*',);
                $event->query->addSelect(DB::raw("'$new' as barcode"));
            }

            // $hasBarcode = $event->query->clone()->whereHas('inventory', function ($query) use ($new) {
            //     $query->where('barcode', 'like', '%' . $new . '%');
            // })->exists();

            // if ($hasBarcode) {
            //     $event->query->addSelect('*',);
            //     $event->query->addSelect(DB::raw("'$new' as barcode"));
            // }
        }
    }
}
