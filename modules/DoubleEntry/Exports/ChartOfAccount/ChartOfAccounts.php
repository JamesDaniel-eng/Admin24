<?php

namespace Modules\DoubleEntry\Exports\ChartOfAccount;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\DoubleEntry\Exports\ChartOfAccount\Sheets\Items;
use Modules\DoubleEntry\Exports\ChartOfAccount\Sheets\Taxes;
use Modules\DoubleEntry\Exports\ChartOfAccount\Sheets\Accounts;
use Modules\DoubleEntry\Exports\ChartOfAccount\Sheets\ItemTaxes;
use Modules\DoubleEntry\Exports\ChartOfAccount\Sheets\ChartOfAccounts as Base;

class ChartOfAccounts implements WithMultipleSheets
{
    use Exportable;

    public $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    public function sheets(): array
    {
        return [
            new Base($this->ids),
            //new Accounts($this->ids),
            new Items($this->ids),
            new ItemTaxes($this->ids),
            new Taxes($this->ids),
        ];
    }
}
