<?php

namespace Modules\DoubleEntry\Exports\ChartOfAccount\Sheets;

use App\Abstracts\Export;
use App\Models\Setting\Tax as Model;
use Modules\DoubleEntry\Models\AccountTax;
use App\Http\Requests\Setting\Tax as Request;

class Taxes extends Export
{
    public $request_class = Request::class;

    public function collection()
    {
        $tax_ids = new AccountTax();

        if ($this->ids) {
            $tax_ids = $tax_ids->whereIn('account_id', $this->ids);
        }

        $tax_ids = $tax_ids->pluck('tax_id')->toArray();

        return Model::whereIn('id', $tax_ids)
            ->with('de_tax', 'de_tax.account')
            ->cursor();
    }

    public function map($model): array
    {
        $model->account_code = $model->de_tax->account->code;      

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'name',
            'type',
            'rate',
            'account_code',
            'enabled',
            'created_from',
            'created_by',
        ];
    }
}