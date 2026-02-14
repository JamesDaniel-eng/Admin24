<?php

namespace Modules\DoubleEntry\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JournalEntryLedger extends JsonResource
{    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id'                => $this->id,
            'company_id'        => $this->company_id,
            'account_id'        => $this->account_id,
            'transaction_id'    => $this->transaction_id,
            'ledgerable_type'   => $this->ledgerable_type,
            'ledgerable_id'     => $this->ledgerable_id,
            'issued_at'         => $this->issued_at,
            'entry_type'        => $this->entry_type,
            'debit'             => $this->debit,
            'has_debit'         => $this->debit ? true : false,
            'credit'            => $this->credit,
            'has_credit'        => $this->credit ? true : false,
            'reference'         => $this->reference,
            'notes'             => $this->basis,
            'created_from'      => $this->created_from,
            'created_by'        => $this->created_by,
            'created_at'        => $this->created_at ? $this->created_at->toIso8601String() : '',
            'updated_at'        => $this->updated_at ? $this->updated_at->toIso8601String() : '',
        ];
    }
}
