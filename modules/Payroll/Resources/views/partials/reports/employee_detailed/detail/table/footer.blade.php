@php $grand_total = array_sum($class->footer_totals[$table_key]); @endphp

<tfoot>
    <tr>
        <td class="{{ $class->column_name_width }} py-2 ltr:text-left rtl:text-right text-black-400 font-bold uppercase">
            {{ trans_choice('general.totals', 1) }}
        </td>

        @foreach($class->footer_totals[$table_key] as $total)
            <td class="{{ $class->column_value_width }} py-2 ltr:text-right rtl:text-left text-black-400 font-medium text-xs print-alignment">
                @if(is_numeric($total))
                    <x-money :amount="$total" :currency="setting('default.currency')" convert />
                @endif
            </td>
        @endforeach

        <td class="{{ $class->column_name_width }} py-2 ltr:text-right rtl:text-left text-black-400 font-medium text-xs print-alignment">
            <x-money :amount="$grand_total" :currency="setting('default.currency')" convert />
        </td>
    </tr>
</tfoot>