<?php

namespace Modules\DoubleEntry\Observers\Common;

use App\Abstracts\Observer;
use App\Models\Common\Item as Model;
use App\Traits\Modules;
use Modules\DoubleEntry\Models\AccountItem;
use Modules\DoubleEntry\Traits\Accounts;

class Item extends Observer
{
    use Accounts, Modules;

    /**
     * Listen to the saved event.
     *
     * @param  Model  $item
     * @return void
     */
    public function saved(Model $item)
    {
        if ($this->moduleIsDisabled('double-entry')) {
            return;
        }

        $income_account = setting('double-entry.accounts_sales', 400);
        $expense_account = setting('double-entry.accounts_expenses', 628);

        if (isset($item->allAttributes['income_account'])) {
            $income_account = $item->allAttributes['income_account'];
        }

        if (isset($item->allAttributes['expense_account'])) {
            $expense_account = $item->allAttributes['expense_account'];
        }

        $item->allAttributes['de_income_account_id'] = $this->findImportedAccountId($income_account);
        $item->allAttributes['de_expense_account_id'] = $this->findImportedAccountId($expense_account);

        if (isset($item->allAttributes['de_income_account_id'])) {
            AccountItem::updateOrCreate(
                ['company_id' => company_id(), 'item_id' => $item->id, 'type' => 'income'],
                ['account_id' => $item->allAttributes['de_income_account_id']]
            );
        }

        if (isset($item->allAttributes['de_expense_account_id'])) {
            AccountItem::updateOrCreate(
                ['company_id' => company_id(), 'item_id' => $item->id, 'type' => 'expense'],
                ['account_id' => $item->allAttributes['de_expense_account_id']]
            );
        }
    }

    /**
     * Listen to the deleted event.
     *
     * @param  Model  $item
     * @return void
     */
    public function deleted(Model $item)
    {
        if ($this->moduleIsDisabled('double-entry')) {
            return;
        }

        AccountItem::where([
            'item_id' => $item->id,
        ])->delete();
    }
}
