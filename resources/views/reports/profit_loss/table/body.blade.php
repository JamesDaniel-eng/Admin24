<tbody>
    @php
        // Determine if this table should be shown
        $show_table = true;
        if ($class->has_double_entry_segments ?? false) {
            // In DoubleEntry mode, show only segment tables (not income/expense)
            $show_table = !in_array($table_key, ['income', 'expense']);
        } else {
            // In default mode, show only income, and expense (NOT gross_profit, total_expenses, or net_profit)
            $show_table = in_array($table_key, ['income', 'expense']);
        }
    @endphp

    @if ($show_table)
        @if (!empty($class->row_values[$table_key]) && is_array($class->row_values[$table_key]) && !empty($class->row_tree_nodes[$table_key]))
            @foreach($class->row_tree_nodes[$table_key] as $id => $node)
                @include($class->views['detail.table.row'], ['tree_level' => 0])
            @endforeach
        @elseif (in_array($table_key, ['gross_profit', 'total_expenses']))
            {{-- Calculated sections, no rows to display --}}
        @else
            <tr>
                <td colspan="{{ count($class->dates) + 2 }}">
                    <div class="text-muted pl-0">{{ trans('general.no_records') }}</div>
                </td>
            </tr>
        @endif
    @endif
</tbody>
