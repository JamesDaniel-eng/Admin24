<?php

namespace Modules\DoubleEntry\Listeners;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterApplying;
use App\Events\Report\FilterShowing;
use App\Events\Report\GroupApplying;
use App\Events\Report\GroupShowing;
use App\Events\Report\RowsShowing;
use App\Models\Document\Document;
use App\Models\Document\DocumentTotal;
use App\Reports\ExpenseSummary;
use App\Reports\IncomeExpenseSummary;
use App\Reports\ProfitLoss;
use App\Traits\Currencies;
use App\Utilities\Date;
use Modules\DoubleEntry\Models\Account;
use Modules\DoubleEntry\Traits\Accounts;
use Throwable;

class AddCoaToCoreReports extends Listener
{
    use Accounts, Currencies;

    protected $classes = [
        'App\Reports\IncomeSummary',
        'App\Reports\ExpenseSummary',
        'App\Reports\IncomeExpenseSummary',
        'App\Reports\ProfitLoss',
    ];

    /**
     * Handle filter showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleFilterShowing(FilterShowing $event)
    {
        if ($this->skipRowsShowing($event, 'de_account')) {
            return;
        }

        unset($event->class->filters['categories']);

        $types = match(get_class($event->class)) {
            'App\Reports\IncomeSummary' => [13, 14, 15],
            'App\Reports\ExpenseSummary' => [11, 12],
        default=> [],
        };

        if (empty($types)) {
            return;
        }

        $accounts = Account::inType($types)
            ->get()
            ->mapWithKeys(function ($account) {
                $name = is_array(trans($account->name)) ? $account->name : trans($account->name);
                $label = $account->code ? $account->code . ' - ' . $name : $name;
                return [$account->id => $label];
            })
            ->sort()
            ->all();

        $event->class->filters['de_accounts'] = $accounts;
        $event->class->filters['names']['de_accounts'] = trans_choice('double-entry::general.chart_of_accounts', 1);
        $event->class->filters['operators']['de_accounts'] = [
            'equal' => true,
            'not_equal' => false,
            'range' => false,
        ];
        $event->class->filters['multiple']['de_accounts'] = true;
    }

    /**
     * Handle filter applying event.
     *
     * @param  $event
     * @return void
     */
    public function handleFilterApplying(FilterApplying $event)
    {
        if ($this->skipRowsShowing($event, 'de_account')) {
            return;
        }

        $de_account_id = $this->getSearchStringValue('de_account_id');

        if (empty($de_account_id)) {
            return;
        }

        try {
            $event->model->where(function ($query) use ($de_account_id) {
                return $query->whereHas('de_ledger', function ($query) use ($de_account_id) {
                    $query->where('account_id', $de_account_id);
                })->orWhereHas('items.de_ledger', function ($query) use ($de_account_id) {
                    $query->where('account_id', $de_account_id);
                })->orWhereHas('item_taxes.de_ledger', function ($query) use ($de_account_id) {
                    $query->where('account_id', $de_account_id);
                })->orWhereHas('totals.de_ledger', function ($query) use ($de_account_id) {
                    $query->where('account_id', $de_account_id);
                });
            });
        } catch (Throwable $th) {
            return;
        }
    }

    /**
     * Handle group showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleGroupShowing(GroupShowing $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $event->class->groups['de_account'] = trans_choice('double-entry::general.chart_of_accounts', 1);
    }

    /**
     * Handle group applying event.
     *
     * @param  $event
     * @return void
     */
    public function handleGroupApplying(GroupApplying $event)
    {
        if ($this->skipRowsShowing($event, 'de_account')) {
            return;
        }

        switch ($event->model->getTable()) {
            case 'documents':
                $items = $event->model->items()->get()->merge($event->model->totals()->code('discount')->get());
                $event->model->type = $event->model->type == 'bill' ? 'expense' : 'income';

                break;
            case 'transactions' && !is_null($event->model->document_id):
                $items = $event->model->document->items()->get()->merge($event->model->document->totals()->code('discount')->get());

                break;
            case 'transactions' && is_null($event->model->document_id):
            case 'double_entry_journals':
                $items = collect([$event->model]);

                break;
            default:
                $items = collect([]);

                break;
        }

        if ($items->isEmpty()) {
            return;
        }

        $items->each(function ($item) use (&$event) {
            $item->type = $event->model->type;

            if ($item instanceof DocumentTotal) {
                $item->type = $item->type == Document::BILL_TYPE ? 'expense' : 'income';
            }

            $item->table = $item->type;
        });

        $filter = $this->getSearchStringValue('de_account_id');

        foreach ($items as $item) {
            $model = $item->de_ledger();

            if (!empty($filter)) {
                $model->where('account_id', $filter);
            }

            $ledgers = $model->with('account.type.declass')->get();

            if ($ledgers->isEmpty()) {
                continue;
            }

            foreach ($ledgers as $ledger) {
                if (!empty($event->model->parent_id) && isset($event->model->issued_at)) {
                    $ledger->issued_at = $event->model->issued_at->toDateTimeString();
                }

                if (!empty($event->model->parent_id) && isset($event->model->paid_at)) {
                    $ledger->issued_at = $event->model->paid_at->toDateTimeString();
                }

                $this->setTotals($event, $ledger, $item->type, $item->table);
            }
        }
    }

    public function setTotals($event, $ledger, $type, $table, $check_type = false)
    {
        $date = $this->getFormattedDate($event, Date::parse($ledger->issued_at));

        // For ProfitLoss, route to the correct segment instead of using income/expense
        $target_table = $table;
        if ($event->class instanceof ProfitLoss) {
            $account = $ledger->account;
            $target_table = $this->getSegmentForAccount($account);
            
            // Skip if account doesn't belong in P&L (e.g., balance sheet accounts)
            if ($target_table === null) {
                return;
            }
            
            // For ProfitLoss, initialize on-demand since RowsShowing happens after GroupApplying
            if (!isset($event->class->row_values[$target_table])) {
                $event->class->row_values[$target_table] = [];
            }
            if (!isset($event->class->row_values[$target_table][$ledger->account_id])) {
                $event->class->row_values[$target_table][$ledger->account_id] = [];
            }
            if (!isset($event->class->row_values[$target_table][$ledger->account_id][$date])) {
                $event->class->row_values[$target_table][$ledger->account_id][$date] = 0;
            }
            if (!isset($event->class->footer_totals[$target_table])) {
                $event->class->footer_totals[$target_table] = [];
            }
            if (!isset($event->class->footer_totals[$target_table][$date])) {
                $event->class->footer_totals[$target_table][$date] = 0;
            }
        } else {
            // For other reports, check if already initialized
            if (
                !isset($event->class->row_values[$target_table][$ledger->account_id])
                || !isset($event->class->row_values[$target_table][$ledger->account_id][$date])
                || !isset($event->class->footer_totals[$target_table][$date])
            ) {
                return;
            }
        }

        // Calculate net amount: credit - debit for income, debit - credit for expenses
        $debit = (float) ($ledger->debit ?? 0);
        $credit = (float) ($ledger->credit ?? 0);
        
        // For ProfitLoss, use the correct formula based on account class
        if ($event->class instanceof ProfitLoss) {
            // Income accounts: credit - debit (income naturally credits)
            // Expense accounts: debit - credit (expenses naturally debit)
            if ($ledger->account->type->declass->name == 'double-entry::classes.income') {
                $amount = $credit - $debit;
            } else {
                // Expense and other accounts
                $amount = $debit - $credit;
            }
        } else {
            // For other reports, use credit - debit
            $amount = $credit - $debit;
        }

        if (empty($amount)) {
            return;
        }

        switch ($ledger->ledgerable_type) {
            case 'App\Models\Document\DocumentItem':
                $from_code = $ledger->ledgerable?->document->currency_code;
                $from_rate = $ledger->ledgerable?->document->currency_rate ?? currency($from_code)?->getRate();
                break;

            default:
                $from_code = $ledger->ledgerable?->currency_code ?? setting('default.currency');
                $from_rate = $ledger->ledgerable?->currency_rate ?? currency($from_code)?->getRate();
                break;
        }

        $amount = $this->convertToDefault($amount, $from_code, $from_rate);

        // For IncomeExpenseSummary, check type match (skip for ProfitLoss)
        if (($event->class instanceof IncomeExpenseSummary) &&
            !str_contains($ledger->account->type->declass->name, $type)) {
            return;
        }

        // For non-ProfitLoss reports, apply sign adjustments
        if (!($event->class instanceof ProfitLoss)) {
            if (($event->class instanceof ExpenseSummary || $event->class instanceof IncomeExpenseSummary) &&
                $ledger->account->type->declass->name == 'double-entry::classes.expenses' &&
                $ledger->credit) {
                $amount = $amount * -1;
            }

            if ($ledger->account->type->declass->name == 'double-entry::classes.income' && $ledger->debit) {
                $amount = $amount * -1;
            }
        }

        if (($check_type == false) || ($type == 'income')) {
            $event->class->row_values[$target_table][$ledger->account_id][$date] += $amount;
            $event->class->footer_totals[$target_table][$date] += $amount;
        } else {
            $event->class->row_values[$target_table][$ledger->account_id][$date] -= $amount;
            $event->class->footer_totals[$target_table][$date] -= $amount;
        }
    }

    /**
     * Handle records showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleRowsShowing(RowsShowing $event)
    {
        if ($this->skipRowsShowing($event, 'de_account')) {
            return;
        }

        \Log::info("handleRowsShowing: START - Processing P&L by CoA");
        \Log::info("handleRowsShowing: footer_totals keys = " . json_encode(array_keys($event->class->footer_totals)));

        $types = match(get_class($event->class)) {
            'App\Reports\IncomeSummary' => [13, 14, 15],
            'App\Reports\ExpenseSummary' => [11, 12],
            'App\Reports\IncomeExpenseSummary' => [11, 12, 13, 14, 15],
            'App\Reports\ProfitLoss' => [11, 12, 13, 14, 15],
        };

        $accounts = Account::inType($types)
            ->with(['sub_accounts'])
            ->orderBy('code')
            ->get(['id', 'account_id', 'code', 'name', 'type_id'])
            ->transform(function ($account, $key) {
                $account->name = $account->trans_name;
                return $account;
            })
            ->all();

        $this->setRowNamesAndValues($event, $accounts);

        $nodes = $this->getAccountsNodes($accounts);

        // For ProfitLoss with segments, filter nodes by segment
        if ($event->class instanceof ProfitLoss) {
            $this->setTreeNodesWithSegments($event, $nodes, $accounts);
            // Mark that DoubleEntry segments are being used
            $event->class->has_double_entry_segments = true;
            // Note: calculateDoubleEntryTotals() is called from ProfitLoss::array() at render time
            // This ensures all segment data is populated before calculating derived totals
        } else {
            $this->setTreeNodes($event, $nodes);
        }
    }

    protected function getSegmentForAccount($account)
    {
        // Type 13, 14, 15 = Income/Sales
        if (in_array($account->type_id, [13, 14, 15])) {
            return 'sales';
        }

        // Type 11 = Cost of Goods Sold / Direct Costs
        // All Type 11 accounts are Direct Costs by definition
        if ($account->type_id === 11) {
            return 'direct_costs';
        }

        // Type 12 = Expenses - determine if salary or operating expense based on account name
        if ($account->type_id === 12) {
            // Extract the first word of the account name for classification
            $first_word = $this->getFirstWordOfAccountName($account);
            
            // Check if it's a salary-related account based on name patterns
            $is_salary = $this->isSalaryAccount($first_word);
            
            if ($is_salary) {
                return 'salaries';
            }
            return 'other_expenses';
        }

        // For any other type_id, return null to indicate it should be skipped
        return null;
    }

    /**
     * Extract the first word from an account name (before space or hyphen).
     * 
     * @param  $account
     * @return string
     */
    protected function getFirstWordOfAccountName($account)
    {
        // Get the account name (translated if it's a translation key)
        $name = is_array(trans($account->name)) ? $account->name : trans($account->name);
        
        // Extract first word (before space or hyphen)
        $words = preg_split('/[\s\-&]+/', trim($name), 2);
        return strtolower(trim($words[0] ?? ''));
    }

    /**
     * Check if account name indicates a salary/payroll account.
     * 
     * @param  string $first_word
     * @return bool
     */
    protected function isSalaryAccount($first_word)
    {
        // List of words that indicate a salary/payroll account
        $salary_keywords = [
            'salary',
            'payroll',
            'wage',
            'wages',
            'compensation',
            'salaries',
            'payslip',
            'pension',
            'bonus',
            'gratuity',
        ];
        
        return in_array($first_word, $salary_keywords, true);
    }

    protected function filterNodesBySegment($nodes, $accounts, $segment, $by_original_table = false)
    {
        if (!is_array($nodes) && !($nodes instanceof \Traversable)) {
            return [];
        }

        $filtered = [];
        foreach ($nodes as $node_id => $children) {
            $account = collect($accounts)->firstWhere('id', $node_id);
            if (!$account) {
                continue;
            }

            if ($by_original_table) {
                // Filter by original table (income/expense)
                $original_table = in_array($account->type_id, [13, 14, 15]) ? 'income' : 'expense';
                if ($original_table === $segment) {
                    if (is_array($children) && !empty($children)) {
                        $filtered[$node_id] = $this->filterNodesBySegment($children, $accounts, $segment, true);
                    } else {
                        $filtered[$node_id] = $children;
                    }
                }
            } else {
                // Filter by segment
                if ($this->getSegmentForAccount($account) === $segment) {
                    if (is_array($children) && !empty($children)) {
                        $filtered[$node_id] = $this->filterNodesBySegment($children, $accounts, $segment, false);
                    } else {
                        $filtered[$node_id] = $children;
                    }
                }
            }
        }
        return $filtered;
    }

    public function setRowNamesAndValues($event, $accounts)
    {
        foreach ($event->class->dates as $date) {
            foreach ($event->class->tables as $table_key => $table_name) {
                // Skip calculated sections - they have no account rows
                if (in_array($table_key, ['gross_profit', 'total_expenses', 'net_profit'])) {
                    continue;
                }
                
                foreach ($accounts as $account) {
                    $account_name = !empty($account->code) 
                        ? $account->code . ' - ' . $account->name 
                        : $account->name;
                    $event->class->row_names[$table_key][$account->id] = $account_name;
                    $event->class->row_values[$table_key][$account->id][$date] = 0;
                }
            }
        }
    }

    protected function setTreeNodesWithSegments($event, $nodes, $accounts)
    {
        // For ProfitLoss, filter tree nodes by segment
        foreach ($event->class->tables as $table_key => $table_name) {
            foreach ($nodes as $parent_id => $children) {
                $account = collect($accounts)->firstWhere('id', $parent_id);
                if ($account && $this->getSegmentForAccount($account) === $table_key) {
                    $event->class->row_tree_nodes[$table_key][$parent_id] = $children ? $this->filterNodesBySegment($children, $accounts, $table_key) : [];
                }
            }
        }
    }
}
