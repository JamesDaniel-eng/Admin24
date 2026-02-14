<div class="overflow-x-scroll large-overflow-unset mb-8">
    <table class="w-full small-table-width  rp-border-collapse">
        <tbody>
            <tr>
                <td class="{{ $class->column_name_width }} w-24 ltr:text-left rtl:text-right text-black-400 uppercase font-bold">
                    {{ trans('reports.net_profit') }}
                </td>

                @foreach($class->dates as $date)
                <td class="{{ $class->column_value_width }} ltr:text-right rtl:text-left text-black-400 font-medium text-xs print-alignment">
                    @if ($class->has_double_entry_segments ?? false)
                        @php
                        // Recalculate based on segment totals for this date
                        $sales = $class->footer_totals['sales'][$date] ?? 0;
                        $direct_costs = $class->footer_totals['direct_costs'][$date] ?? 0;
                        $other_expenses = $class->footer_totals['other_expenses'][$date] ?? 0;
                        $salaries = $class->footer_totals['salaries'][$date] ?? 0;

                        $calculated_value = $sales - ($direct_costs + $other_expenses + $salaries);
                        @endphp
                    <x-money :amount="$calculated_value" />
                    @else
                    <x-money :amount="$class->net_profit[$date] ?? 0" />
                    @endif
                </td>
                @endforeach

                <td class="{{ $class->column_name_width }} ltr:text-right rtl:text-left text-black-400 font-medium text-xs print-alignment">
                    @if ($class->has_double_entry_segments ?? false)
                        @php
                        // Recalculate based on segment totals for this date
                        $sales = $class->footer_totals['sales'] ?? [];
                        $direct_costs = $class->footer_totals['direct_costs'] ?? [];
                        $other_expenses = $class->footer_totals['other_expenses'] ?? [];
                        $salaries = $class->footer_totals['salaries'] ?? [];

                        $calculated_value = array_sum($sales) - (array_sum($direct_costs) + array_sum($other_expenses) + array_sum($salaries));
                        @endphp
                    <x-money :amount="$calculated_value" />
                    @else
                        <x-money :amount="array_sum($class->net_profit ?? [])" />
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
