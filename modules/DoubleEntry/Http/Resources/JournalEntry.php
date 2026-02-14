<?php

namespace Modules\DoubleEntry\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\DoubleEntry\Http\Resources\JournalEntryLedger;

class JournalEntry extends JsonResource
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
            'journal_number'    => $this->number,
            'paid_at'           => $this->paid_at,
            'amount'            => $this->amount,
            'amount_formatted'  => money($this->amount, $this->currency_code)->format(),
            'currency_code'     => $this->currency_code,
            'currency_rate'     => $this->currency_rate,
            'description'       => $this->description,
            'reference'         => $this->reference,
            'basis'             => $this->basis,
            'attachment'        => $this->attachment,
            'ledgers'           => [static::$wrap => JournalEntryLedger::collection($this->ledgers)],
            'created_from'      => $this->created_from,
            'created_by'        => $this->created_by,
            'created_at'        => $this->created_at ? $this->created_at->toIso8601String() : '',
            'created_at'        => $this->created_at ? $this->created_at->toIso8601String() : '',
            'updated_at'        => $this->updated_at ? $this->updated_at->toIso8601String() : '',
        ];
    }
}
