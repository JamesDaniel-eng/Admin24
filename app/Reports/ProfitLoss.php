<?php

namespace App\Reports;

use App\Abstracts\Report;
use App\Models\Banking\Transaction;
use App\Models\Common\Report as ReportModel;
use App\Models\Document\Document;
use App\Traits\Currencies;
use App\Utilities\Date;
use App\Utilities\Recurring;
use Modules\DoubleEntry\Reports\GeneralLedger;

class ProfitLoss extends Report
{
    use Currencies;
    public $default_name = 'reports.profit_loss';

    public $category = 'general.accounting';

    public $icon = 'favorite_border';

    public $type = 'detail';

    public $chart = false;

    public $general_ledger_report;

    public $has_double_entry_segments = false;

    public function setViews()
    {
        parent::setViews();
        $this->views['detail.content.header'] = 'reports.profit_loss.content.header';
        $this->views['detail.content.footer'] = 'reports.profit_loss.content.footer';
        $this->views['detail.table.header'] = 'reports.profit_loss.table.header';
        $this->views['detail.table.body'] = 'reports.profit_loss.table.body';
        $this->views['detail.table.footer'] = 'reports.profit_loss.table.footer';
    }

    public function setTables()
    {
        $this->tables = [
            'income' => trans_choice('general.incomes', 1),
            'expense' => trans_choice('general.expenses', 2),
            'sales' => trans('reports.segments.sales'),
            'direct_costs' => trans('reports.segments.direct_costs'),
            'other_expenses' => trans('reports.segments.other_expenses'),
            'salaries' => trans('reports.segments.salaries'),
            'gross_profit' => trans('reports.segments.gross_profit'),
            'total_expenses' => trans('reports.segments.total_expenses'),
        ];
    }

    public function setData()
    {
        // Fetch the general ledger report for this company
        $this->general_ledger_report = ReportModel::where('class', GeneralLedger::class)->first();

        // Initialize row_names, row_values and footer_totals for all segments
        foreach ($this->dates as $date) {
            foreach ($this->tables as $table_key => $table_name) {
                if (!isset($this->row_names[$table_key])) {
                    $this->row_names[$table_key] = [];
                }
                if (!isset($this->row_values[$table_key])) {
                    $this->row_values[$table_key] = [];
                }
                $this->footer_totals[$table_key][$date] = 0;
            }
        }

        $income_transactions = $this->applyFilters(Transaction::with('recurring')->income()->isNotTransfer(), ['date_field' => 'paid_at']);
        $expense_transactions = $this->applyFilters(Transaction::with('recurring')->expense()->isNotTransfer(), ['date_field' => 'paid_at']);

        // Check if we're using P&L by CoA
        $is_de_account = !empty($this->model->settings->group) && $this->model->settings->group === 'de_account';
        
        switch ($this->getBasis()) {
            case 'cash':
                if (!$is_de_account) {
                    // Incomes
                    $incomes = $income_transactions->get();
                    $this->setTotals($incomes, 'paid_at', false, 'income', false);

                    // Expenses
                    $expenses = $expense_transactions->get();
                    $this->setTotals($expenses, 'paid_at', false, 'expense', false);
                }

                break;
            default:
                if (!$is_de_account) {
                    // Invoices
                    $invoices = $this->applyFilters(Document::invoice()->with('recurring', 'totals', 'transactions', 'items')->accrued(), ['date_field' => 'issued_at'])->get();
                    Recurring::reflect($invoices, 'issued_at');
                    $this->setTotals($invoices, 'issued_at', false, 'income', false);

                    // Incomes
                    $incomes = $income_transactions->isNotDocument()->get();
                    Recurring::reflect($incomes, 'paid_at');
                    $this->setTotals($incomes, 'paid_at', false, 'income', false);

                    // Bills
                    $bills = $this->applyFilters(Document::bill()->with('recurring', 'totals', 'transactions', 'items')->accrued(), ['date_field' => 'issued_at'])->get();
                    Recurring::reflect($bills, 'issued_at');
                    $this->setTotals($bills, 'issued_at', false, 'expense', false);

                    // Expenses
                    $expenses = $expense_transactions->isNotDocument()->get();
                    Recurring::reflect($expenses, 'paid_at');
                    $this->setTotals($expenses, 'paid_at', false, 'expense', false);
                } else {
                    // For P&L by CoA, we still need to get the documents to trigger applyGroups events
                    $invoices = $this->applyFilters(Document::invoice()->with('recurring', 'totals', 'transactions', 'items')->accrued(), ['date_field' => 'issued_at'])->get();
                    Recurring::reflect($invoices, 'issued_at');
                    // Apply groups to trigger listener events
                    foreach ($invoices as $invoice) {
                        $this->applyGroups($invoice);
                    }

                    // Incomes
                    $incomes = $income_transactions->isNotDocument()->get();
                    Recurring::reflect($incomes, 'paid_at');
                    foreach ($incomes as $income) {
                        $this->applyGroups($income);
                    }

                    // Bills
                    $bills = $this->applyFilters(Document::bill()->with('recurring', 'totals', 'transactions', 'items')->accrued(), ['date_field' => 'issued_at'])->get();
                    Recurring::reflect($bills, 'issued_at');
                    foreach ($bills as $bill) {
                        $this->applyGroups($bill);
                    }

                    // Expenses
                    $expenses = $expense_transactions->isNotDocument()->get();
                    Recurring::reflect($expenses, 'paid_at');
                    foreach ($expenses as $expense) {
                        $this->applyGroups($expense);
                    }
                }

                break;
        }
        
        // For P&L by CoA, calculate derived totals AFTER all segment data is populated
        if ($this->has_double_entry_segments) {
            \Log::info("DoubleEntry Mode Detected in setData");
            $this->calculateDoubleEntryTotals();
        } else {
            // For default mode, calculate net profit directly
            \Log::info("NO DoubleEntry Mode Detected in setData");
            $this->setNetProfit();
        }
    }

    public function setNetProfit()
    {
        foreach ($this->dates as $date) {
            // For default mode (non-DoubleEntry), calculate Net Profit from income/expense
            if (!$this->has_double_entry_segments) {
                $income = $this->footer_totals['income'][$date] ?? 0;
                $expense = $this->footer_totals['expense'][$date] ?? 0;
                $net_profit = $income - $expense;
                $this->footer_totals['net_profit'][$date] = $net_profit;
                $this->net_profit[$date] = $net_profit;
            }
        }
    }

    public function calculateDoubleEntryTotals()
    {
        // This method is called AFTER all row_values are populated by the listener
        // It calculates Gross Profit, Total Expenses, and Net Profit from segment rows
        foreach ($this->dates as $date) {
            // Read directly from footer_totals that were populated by listener's setTotals
            $sales = $this->footer_totals['sales'][$date] ?? 0;
            $direct_costs = $this->footer_totals['direct_costs'][$date] ?? 0;
            $other_expenses = $this->footer_totals['other_expenses'][$date] ?? 0;
            $salaries = $this->footer_totals['salaries'][$date] ?? 0;
            
            \Log::info("calculateDoubleEntryTotals: date=$date");
            \Log::info("  Input values: sales=$sales, direct_costs=$direct_costs, other_expenses=$other_expenses, salaries=$salaries");
            
            // Calculate each component
            $gross_profit = $sales - $direct_costs;
            $total_expenses = $direct_costs + $other_expenses + $salaries;
            $net_profit = $sales - $total_expenses;
            
            \Log::info("  Calculations:");
            \Log::info("    gross_profit = $sales - $direct_costs = $gross_profit");
            \Log::info("    total_expenses = $direct_costs + $other_expenses + $salaries = $total_expenses");
            \Log::info("    net_profit = $sales - $total_expenses = $net_profit");
            
            // Store in footer_totals
            $this->footer_totals['gross_profit'][$date] = $gross_profit;
            $this->footer_totals['total_expenses'][$date] = $total_expenses;
            $this->footer_totals['net_profit'][$date] = $net_profit;
            $this->net_profit[$date] = $net_profit;
            
            \Log::info("  Stored in footer_totals: gross_profit=$gross_profit, total_expenses=$total_expenses, net_profit=$net_profit");
        }
    }
}
