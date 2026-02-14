@php 
    /**
     * DEBUG: Print the data structure being sent to this view
     *
     * if (config('app.debug')) {
     * echo '<div style="background: #f5f5f5; border: 1px solid #ddd; padding: 10px; margin: 10px 0; font-size: 11px; overflow-x: auto;">';
     * echo '<strong>DEBUGS - Table Footer Data for: ' . htmlspecialchars($table_key) . '</strong><br>';
     * echo '<strong>has_double_entry_segments:</strong> ' . ($class->has_double_entry_segments ? 'TRUE' : 'FALSE') . '<br>';
     * echo '<strong>footer_totals keys:</strong> ' . htmlspecialchars(json_encode(array_keys($class->footer_totals))) . '<br>';
     * echo '<strong>footer_totals[' . htmlspecialchars($table_key) . ']:</strong> ' . htmlspecialchars(json_encode($class->footer_totals[$table_key] ?? 'NOT SET')) . '<br>';
     * echo '<strong>All footer_totals:</strong><pre>' . htmlspecialchars(json_encode($class->footer_totals, JSON_PRETTY_PRINT)) . '</pre>';
     * echo '</div>';
     * }
    */
    
    /**
     * SEGMENT TOTALS LOGIC - Understanding How Totals Are Populated
     * ================================================================
     * 
     * P&L by CoA Mode (has_double_entry_segments = true):
     * ─────────────────────────────────────────────────
     * 1. Listener processes transactions in GroupApplying phase
     *    → setTotals() is called for each transaction
     *    → Routes account to segment via getSegmentForAccount()
     *    → Accumulates amounts into:
     *       footer_totals['sales'][$date] ← All Type 13, 14, 15 accounts
     *       footer_totals['direct_costs'][$date] ← All Type 11 accounts  
     *       footer_totals['other_expenses'][$date] ← Type 12 non-salary
     *       footer_totals['salaries'][$date] ← Type 12 with salary keywords
     * 
     * 2. In RowsShowing phase, calculateDoubleEntryTotals() computes:
     *    footer_totals['gross_profit'][$date] = sales - direct_costs
     *    footer_totals['total_expenses'][$date] = direct_costs + other_expenses + salaries
     *    footer_totals['net_profit'][$date] = sales - total_expenses
     * 
     * 3. Template displays all 7 totals (segments + calculated sections)
     *    → income and expense tables are NOT populated, remain zero, are hidden
     * 
     * Default P&L Mode (has_double_entry_segments = false):
     * ──────────────────────────────────────────────────
     * 1. Default report logic populates:
     *    footer_totals['income'][$date] ← All income accounts
     *    footer_totals['expense'][$date] ← All expense accounts
     * 
     * 2. setNetProfit() calculates:
     *    net_profit[$date] = income[$date] - expense[$date]
     * 
     * 3. Template displays only income and expense tables
     *    → Segment tables are NOT populated, remain zero, are hidden
     */
    
    // Determine if this footer should be shown based on mode and table
    $show_footer = true;
    if ($class->has_double_entry_segments ?? true) {
        // P&L by CoA mode: Show all segments and calculated sections, hide income/expense
        $show_footer = !in_array($table_key, ['income', 'expense']);
    } else {
        // Default mode: Show only income, expense, hide segments and calculated sections
        $show_footer = in_array($table_key, ['income', 'expense']);
    }

    // Get the footer totals for this table (populated by listener's setTotals during GroupApplying)
    // For P&L by CoA: This contains segment totals accumulated from transactions
    // For Default: This contains income/expense totals accumulated from transactions
    $footer_total = $class->footer_totals[$table_key] ?? [];
    $grand_total = array_sum($footer_total);
    
    // Check if this is a calculated section (P&L by CoA only)
    $is_calculated_section = in_array($table_key, ['gross_profit', 'total_expenses']);
    
    // Get the display name for calculated sections
    $display_name = $table_name;
    if ($is_calculated_section) {
        $display_name = $table_key === 'gross_profit' 
            ? trans('reports.gross_profit')
            : ($table_key === 'total_expenses' 
                ? trans('reports.total_expenses')
                : trans('reports.net_profit')
            );
    }
@endphp

@if ($show_footer)
<tfoot>
    <tr>
        <td class="{{ $class->column_name_width }} w-24 py-4 ltr:text-left rtl:text-right text-black-400 font-bold uppercase">
            @if (in_array($table_key, ['gross_profit', 'total_expenses']))
                {{ $display_name }}
            @else
                {{ trans_choice('general.totals', 1) }}
            @endif
        </td>

        @foreach($class->dates as $date)
        <td class="{{ $class->column_value_width }} py-4 ltr:text-right rtl:text-left text-black-400 font-medium text-xs print-alignment">
            @if (in_array($table_key, ['gross_profit', 'total_expenses']))
                @php
                    // Recalculate based on segment totals for this date
                    $sales = $class->footer_totals['sales'][$date] ?? 0;
                    $direct_costs = $class->footer_totals['direct_costs'][$date] ?? 0;
                    $other_expenses = $class->footer_totals['other_expenses'][$date] ?? 0;
                    $salaries = $class->footer_totals['salaries'][$date] ?? 0;
                    
                    if ($table_key === 'gross_profit') {
                        $calculated_value = $sales - $direct_costs;
                    } else {
                        $calculated_value = $direct_costs + $other_expenses + $salaries;
                    }
                @endphp
                <x-money :amount="$calculated_value" />
            @else
                {{-- 
                    For regular segments or default P&L tables:
                    footer_total is already an array of date => amount
                    
                    P&L by CoA segments (sales, direct_costs, other_expenses, salaries):
                      → Populated by listener's setTotals() as it processes transactions
                      → Sums all matching account amounts for this segment in this period
                    
                    Default mode (income, expense):
                      → Populated by default report logic
                      → Sums all matching account amounts for income/expense
                --}}
                <x-money :amount="$footer_total[$date] ?? 0" />
            @endif
        </td>
        @endforeach

        <td class="{{ $class->column_name_width }} py-4 ltr:text-right rtl:text-left text-black-400 font-medium text-xs print-alignment">
        @if (in_array($table_key, ['gross_profit', 'total_expenses']))
            @php
                // Recalculate based on segment totals for this date
                $sales = $class->footer_totals['sales'][$date] ?? 0;
                $direct_costs = $class->footer_totals['direct_costs'][$date] ?? 0;
                $other_expenses = $class->footer_totals['other_expenses'][$date] ?? 0;
                $salaries = $class->footer_totals['salaries'][$date] ?? 0;
                    
                if ($table_key === 'gross_profit') {
                    $calculated_value = $sales - $direct_costs;
                } else {
                    $calculated_value = $direct_costs + $other_expenses + $salaries;
                }
            @endphp
            <x-money :amount="$calculated_value" />
        @else
            {{-- Grand total across all dates for this table --}}
            <x-money :amount="$grand_total" />
        @endif
        </td>
    </tr>
</tfoot>
@endif
