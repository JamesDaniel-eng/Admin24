@php
    // Determine if this table should be visible based on report mode
    // Only apply visibility logic for ProfitLoss reports with has_double_entry_segments flag
    $show_table = true;
    
    if (isset($table_key) && isset($class->has_double_entry_segments)) {
        if ($class->has_double_entry_segments) {
            // DoubleEntry mode: show all tables EXCEPT income and expense
            $show_table = !in_array($table_key, ['income', 'expense']);
        } else {
            // Default mode: show only income, expense, and net_profit (NOT gross_profit or total_expenses)
            $show_table = in_array($table_key, ['income', 'expense', 'net_profit']);
        }
    }
@endphp

@if ($show_table)
<div class="overflow-x-scroll large-overflow-unset mb-8 margin-bottom-spacing">
    <table class="w-full small-table-width rp-border-collapse">
        @include($class->views['detail.table.header'])
        @include($class->views['detail.table.body'])
        @include($class->views['detail.table.footer'])
    </table>
</div>
@endif

