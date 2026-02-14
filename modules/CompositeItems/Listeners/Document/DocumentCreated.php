<?php

namespace Modules\CompositeItems\Listeners\Document;

use App\Traits\Jobs;
use App\Traits\Modules;
use Modules\CompositeItems\Models\CompositeItem;
use App\Events\Document\DocumentCreated as Event;
use Modules\CompositeItems\Jobs\CreateDocumentItem;

class DocumentCreated
{
    use Modules, Jobs;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (!$this->moduleIsEnabled('composite-items')) {
            return;
        }

        $request = $event->request;
        $document = $event->document;

        foreach ($document->items as $index => $item) {
            $composite_item = CompositeItem::where('item_id', $item->item->id)->first();

            if (! $composite_item) {
                continue;
            }

            $requested_item = $request->items[$index] ?? [];

            if (! $requested_item || ! isset($requested_item['composite_items']) || ! $composite_items = $requested_item['composite_items']) {
                continue;
            }

            foreach ($composite_items[$item->item_id] as $composite_item) {
                $total = $composite_item['amount'];

                $discount = 0;
                if ($item->discount_rate !== 0) {
                    if ($item->discount_type === 'percentage') {
                        $discount = round(($total * ($item->discount_rate / 100)), $document->currency->precision);
                    } else {
                        $discount = $item->discount_rate;
                    }
                }

                $total = $discount ? $total - $discount : $total;

                if ($item->tax !== 0) {
                    $tax_rate = ($item->tax / ($item->total - $item->tax)) * 100;

                    $tax = round(($total * ($tax_rate / 100)), $document->currency->precision);
                }

                $composite_item_request = [
                    'company_id'        => $document->company_id,
                    'item_id'           => $composite_item['item_id'],
                    'document_id'       => $document->id,
                    'document_item_id'  => $item->id,
                    'warehouse_id'      => $composite_item['warehouse_id'] ?? null,
                    'type'              => $document->type,
                    'quantity'          => $composite_item['quantity'],
                    'price'             => $composite_item['price'],
                    'discount_rate'     => $item->discount_rate,
                    'discount_type'     => $item->discount_type,
                    'tax'               => $tax ?? 0,
                    'total'             => $total,
                ];

                $this->ajaxDispatch(new CreateDocumentItem($composite_item_request));
            }
        }
    }
}
