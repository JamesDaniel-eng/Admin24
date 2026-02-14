<?php

namespace Modules\DoubleEntry\Imports\ChartOfAccount\Sheets;

use App\Abstracts\Import;
use App\Models\Common\Item as Model;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Modules\DoubleEntry\Models\AccountItem;
use App\Http\Requests\Common\Item as Request;
use Modules\DoubleEntry\Models\Account as COA;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;

class Items extends Import implements HasReferencesToOtherSheets, WithEvents
{
    use Importable, RegistersEventListeners;

    public $request_class = Request::class;

    public $model = Model::class;

    public $columns = [
        'type',
        'name',
        'sale_price',
        'purchase_price',
    ];

    public function model(array $row)
    {
        if (self::hasRow($row)) {
            return;
        }

        return new Model($row);
    }

    public function map($row): array
    {
        $row = parent::map($row);

        $row['sale_information'] = isset($row['sale_price']) ?? false;

        $row['purchase_information'] = isset($row['purchase_price']) ?? false;

        $row['category_id'] = $this->getCategoryId($row, 'item');

        return $row;
    }

    public function afterSheet(AfterSheet $event)
    {
        $rows = $event->sheet->getDelegate()->toArray();

        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }

            $item_name = $row[array_keys($rows[0], 'name')[0]];

            if (! $item_name) {
                continue;
            }

            $item = Model::where('name', $item_name)->first();

            if (! $item) {
                continue;
            }

            $coa_income_code = $row[array_keys($rows[0], 'income_account_code')[0]];

            if (! $coa_income_code) {
                continue;
            }

            $coa_income = COA::where('code', $coa_income_code)->first();

            if (! $coa_income) {
                continue;
            }

            AccountItem::firstOrCreate([
                'company_id'    => $coa_income->company_id,
                'account_id'    => $coa_income->id,
                'item_id'       => $item->id,
                'type'          => 'income',
            ]);

            $coa_expense_code = $row[array_keys($rows[0], 'expense_account_code')[0]];

            if (! $coa_expense_code) {
                continue;
            }

            $coa_expense = COA::where('code', $coa_expense_code)->first();

            if (! $coa_expense) {
                continue;
            }

            AccountItem::firstOrCreate([
                'company_id'    => $coa_expense->company_id,
                'account_id'    => $coa_expense->id,
                'item_id'       => $item->id,
                'type'          => 'expense',
            ]);
        }
    }
}
