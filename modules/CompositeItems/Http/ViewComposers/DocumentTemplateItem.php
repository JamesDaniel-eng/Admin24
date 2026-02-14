<?php

namespace Modules\CompositeItems\Http\ViewComposers;

use App\Traits\Modules;
use Illuminate\View\View;
use Modules\CompositeItems\Models\DocumentItem;

class DocumentTemplateItem
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
        if (! $this->moduleIsEnabled('composite-items') || ! setting('composite-items.show_in_documents', false)) {
            return;
        }

        $data = $view->getData();

        if (isset($data['item']) && $data['item']->id) {
            $item = $data['item'];

            $compositeItems = DocumentItem::where('document_item_id', $item->id)
                ->with(['item', 'warehouse'])
                ->get();

            if ($compositeItems->count() > 0) {
                $hideQuantity = $data['hideQuantity'] ?? false;
                $hidePrice = $data['hidePrice'] ?? false;
                $hideDiscount = $data['hideDiscount'] ?? false;
                $hideAmount = $data['hideAmount'] ?? false;
                $document = $data['document'];
                $print = $data['print'] ?? false;

                $view->getFactory()->startPush($item->id . '_line_item_end',
                    view('composite-items::partials.document_line_item_composite_row',
                        compact('compositeItems', 'document', 'print', 'hideQuantity', 'hidePrice', 'hideDiscount', 'hideAmount')
                    )
                );
            }
        }
    }
}
