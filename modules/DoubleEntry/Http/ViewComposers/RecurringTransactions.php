<?php

namespace Modules\DoubleEntry\Http\ViewComposers;

use App\Models\Banking\Transaction;
use App\Traits\Modules;
use Illuminate\View\View;
use Modules\DoubleEntry\Models\Account;
use Modules\DoubleEntry\View\Components\Accounts;

class RecurringTransactions
{
    use Modules;

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if ($this->moduleIsDisabled('double-entry')) {
            return;
        }

        $request = request();

        $section = 'category_id_input_start';

        $selected = null;

        if ($request->routeIs('recurring-transactions.edit')) {
            $transaction = $request->route('recurring_transaction');

            $ledger = $transaction->de_recur_ledger()
                ->where('entry_type', 'item')
                ->first();

            // if (is_null($ledger)) {
            //     return;
            // }

            if (!is_null($ledger)) {
                $selected = $ledger->account->id;
            }
        }

        $code = setting('double-entry.accounts_sales', 400);

        if ($request->input('type') === Transaction::EXPENSE_RECURRING_TYPE) {
            $code = setting('double-entry.accounts_expenses', 628);
        }

        $account = Account::code($code)->first();

        if ($account) {
            $selected = $account->id;
        }

        $formGroupClass = 'sm:col-span-3';

        $accounts = new Accounts(selected:$selected, formGroupClass:$formGroupClass);

        $key = $accounts->data();

        $content = $accounts->render()->with($key);

        $view->getFactory()->startPush($section, $content);
    }
}
