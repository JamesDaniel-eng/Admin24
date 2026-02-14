<?php

namespace Modules\DoubleEntry\Imports\ChartOfAccount\Sheets;

use App\Abstracts\Import;
use App\Models\Banking\Account as Model;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Modules\DoubleEntry\Models\AccountBank;
use Modules\DoubleEntry\Models\Account as COA;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;

class Accounts extends Import implements HasReferencesToOtherSheets, WithEvents
{
    use Importable, RegistersEventListeners;

    public $model = Model::class;

    public $columns = [
        'type',
        'name',
        'number'
    ];

    public function model(array $row)
    {
        if (! $row) {
            return;
        }

        if (self::hasRow($row)) {
            return;
        }

        return new Model($row);
    }

    public function map($row): array
    {
        $coa_account = COA::where('name', $row['name'])->first();

        if (! $coa_account) {
            return [];
        }

        $row = parent::map($row);

        $row['number'] = $row['number'] ?? rand(100000000, 999999999);

        return $row;
    }

    public function afterSheet(AfterSheet $event)
    {
        $rows = $event->sheet->getDelegate()->toArray();

        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }

            $coa_code = $row[array_keys($rows[0], 'coa_code')[0]];

            if (! $coa_code) {
                continue;
            }

            $coa = COA::where('code', $coa_code)->first();

            if (! $coa) {
                continue;
            }

            $account_number = $row[array_keys($rows[0], 'number')[0]];

            if (! $account_number) {
                continue;
            }

            $account = Model::where('number', $account_number)->first();

            if (! $account) {
                continue;
            }

            AccountBank::firstOrCreate([
                'company_id' => $coa->company_id,
                'account_id' => $coa->id,
                'bank_id'    => $account->id
            ]);
        }
    }
}
