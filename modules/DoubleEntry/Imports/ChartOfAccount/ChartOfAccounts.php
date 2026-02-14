<?php

namespace Modules\DoubleEntry\Imports\ChartOfAccount;

use App\Abstracts\ImportMultipleSheets;
use Modules\DoubleEntry\Imports\ChartOfAccount\Sheets\Accounts;
use Modules\DoubleEntry\Imports\ChartOfAccount\Sheets\ChartOfAccounts as Base;
use Modules\DoubleEntry\Imports\ChartOfAccount\Sheets\ItemTaxes;
use Modules\DoubleEntry\Imports\ChartOfAccount\Sheets\Items;
use Modules\DoubleEntry\Imports\ChartOfAccount\Sheets\Taxes;

class ChartOfAccounts extends ImportMultipleSheets
{
    public function sheets(): array
    {
        return [
            'chart_of_accounts' => new Base(),
            //'accounts'          => new Accounts(),
            'taxes'             => new Taxes(),
            'items'             => new Items(),
            'item_taxes'        => new ItemTaxes(),
        ];
    }
}
