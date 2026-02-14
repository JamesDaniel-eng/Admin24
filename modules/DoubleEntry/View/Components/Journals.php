<?php

namespace Modules\DoubleEntry\View\Components;

use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use Illuminate\View\Component;

class Journals extends Component
{
    public $referenceDocuments = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($referenceDocuments)
    {
        if ($referenceDocuments instanceof \Plank\Mediable\MediableCollection) {
            foreach ($referenceDocuments as $referenceDocument) {
                if ($referenceDocument instanceof Transaction) {            
                    $referenceDocument->ledgers->load('account');
        
                    foreach ($referenceDocument->taxes as $tax) {
                        if ($ledger = $tax->de_ledger ?? $tax->de_recur_ledger) {
                            $referenceDocuments->ledgers->push($ledger);
                        }
                    }
                }

                $this->referenceDocuments[] = $referenceDocument;
            }

            return;
        }

        if ($referenceDocuments instanceof Document) {
            $referenceDocuments->ledgers = collect();
            
            if ($referenceDocuments->de_ledger) {
                $referenceDocuments->ledgers->push($referenceDocuments->de_ledger);
            }
            
            if ($referenceDocuments->de_recur_ledger) {
                $referenceDocuments->ledgers->push($referenceDocuments->de_recur_ledger);
            }

            foreach ($referenceDocuments->items as $item) {
                $item->load('de_ledger');

                if ($ledger = $item->de_ledger ?? $item->de_recur_ledger) {
                    $referenceDocuments->ledgers->push($ledger);
                }
            }

            foreach ($referenceDocuments->item_taxes as $item_tax) {
                $item_tax->load('de_ledger');

                if ($ledger = $item_tax->de_ledger ?? $item_tax->de_recur_ledger) {
                    $referenceDocuments->ledgers->push($ledger);
                }
            }

            foreach ($referenceDocuments->totals as $total) {
                $total->load('de_ledger');

                if ($ledger = $total->de_ledger ?? $total->de_recur_ledger) {
                    $referenceDocuments->ledgers->push($ledger);
                }
            }
        }

        if ($referenceDocuments instanceof Transaction) {            
            $referenceDocuments->ledgers->load('account');
            $referenceDocuments->recur_ledgers->load('account');

            if ($referenceDocuments->recur_ledgers) {
                foreach ($referenceDocuments->recur_ledgers as $recur_ledger) {
                    $referenceDocuments->ledgers->push($recur_ledger);
                }
            }

            foreach ($referenceDocuments->taxes as $tax) {
                if ($ledger = $tax->de_ledger ?? $tax->de_recur_ledger) {
                    $referenceDocuments->ledgers->push($ledger);
                }
            }
        }

        $this->referenceDocuments[] = $referenceDocuments;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('double-entry::components.journals');
    }
}
