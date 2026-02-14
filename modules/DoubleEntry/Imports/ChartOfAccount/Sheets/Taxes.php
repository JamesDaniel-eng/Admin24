<?php

namespace Modules\DoubleEntry\Imports\ChartOfAccount\Sheets;

use App\Abstracts\Import;
use App\Models\Setting\Tax as Model;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Modules\DoubleEntry\Models\AccountTax;
use App\Http\Requests\Setting\Tax as Request;
use Modules\DoubleEntry\Models\Account as COA;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;

class Taxes extends Import implements HasReferencesToOtherSheets, WithEvents
{
    use Importable, RegistersEventListeners;

    public $request_class = Request::class;

    public $model = Model::class;

    public $columns = [
        'name',
        'type',
    ];

    public function model(array $row)
    {
        if (empty($row)) {
            return;
        }

        if (self::hasRow($row)) {
            return;
        }

        return new Model($row);
    }

    public function map($row): array
    {
        $row = parent::map($row);
        
        if ($row['type'] == 'compound') {
            $compound_tax = Model::where('type', 'compound')->first();

            if ($compound_tax) {
                $this->request_class = null;
                return [];
            }
        }

        return $row;
    }

    public function afterSheet(AfterSheet $event)
    {
        $rows = $event->sheet->getDelegate()->toArray();

        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }

            $account_code = $row[array_keys($rows[0], 'account_code')[0]];

            if (! $account_code) {
                continue;
            }

            $coa = COA::where('code', $account_code)->first();

            if (! $coa) {
                continue;
            }

            $tax_name = $row[array_keys($rows[0], 'name')[0]];

            if (! $tax_name) {
                continue;
            }

            $tax_type= $row[array_keys($rows[0], 'type')[0]];

            if (! $tax_type) {
                continue;
            }

            $tax = Model::where('name', $tax_name)->where('type', $tax_type)->first();

            if (! $tax) {
                continue;
            }

            AccountTax::firstOrCreate([
                'company_id'    => $coa->company_id,
                'account_id'    => $coa->id,
                'tax_id'        => $tax->id
            ]);
        }
    }
}