<?php

namespace Modules\DoubleEntry\Imports\JournalEntry;

use App\Abstracts\ImportMultipleSheets;
use Modules\DoubleEntry\Imports\JournalEntry\Sheets\Accounts;
use Modules\DoubleEntry\Imports\JournalEntry\Sheets\ChartOfAccounts;
use Modules\DoubleEntry\Imports\JournalEntry\Sheets\JournalLedgers;
use Modules\DoubleEntry\Imports\JournalEntry\Sheets\Journals as Base;
use Modules\DoubleEntry\Imports\JournalEntry\Sheets\Transactions;

class Journals extends ImportMultipleSheets
{
    public function sheets(): array
    {
        return [
            'chart_of_accounts' => new ChartOfAccounts(),
            //'accounts'          => new Accounts(),
            'transactions'      => new Transactions(),
            'journals'          => new Base(),
            'journal_ledgers'   => new JournalLedgers(),
        ];
    }
}
