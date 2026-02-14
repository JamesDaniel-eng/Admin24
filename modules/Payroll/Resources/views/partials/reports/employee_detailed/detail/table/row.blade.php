@php $rows = $class->row_values[$table_key][$id]; @endphp

@if ($row_total = array_sum($rows))
    <tr>
        <td class="{{ $class->column_name_width }} py-2 text-left text-black-400 truncate" title="{{ $class->row_names[$table_key][$id] }}">{{ $class->row_names[$table_key][$id] }}</td>
        @foreach($rows as $row_id => $row)
            @if($row_id !== 'benefits' && $row_id !== 'deductions')
                <td class="{{ $class->column_value_width }} py-2 text-right text-black-400 text-xs">
                    @if(is_numeric($row))
                        <x-money :amount="$row" :currency="setting('default.currency')" convert />
                    @endif
                </td>
            @endif
        @endforeach
        <td class="{{ $class->column_name_width }} py-2 text-right text-black-400 text-xs uppercase">
            <x-money :amount="$row_total" :currency="setting('default.currency')" convert />
        </td>
    </tr>
    @foreach($rows['benefits'] as $benefit)
        <tr >
            <td class="{{ $class->column_name_width }} py-2 text-left text-black-400"></td>
            <td class="{{ $class->column_value_width }} py-2 text-right text-black-400 text-xs"></td>
            <td class="{{ $class->column_value_width }} py-2 text-right text-black-400 text-xs">
                {{ $benefit['pay_item'] }}
            </td>
            <td class="{{ $class->column_value_width }} py-2 text-right text-black-400 text-xs">
                <x-money :amount="$benefit['amount']" :currency="setting('default.currency')" convert />
            </td>
            <td class="{{ $class->column_value_width }} py-2 text-right text-black-400 text-xs"></td>
            <td class="{{ $class->column_name_width }} py-2 text-right text-black-400 text-xs"></td>
        </tr>
    @endforeach

    @foreach($rows['deductions'] as $deduction)
        <tr>
            <td class="{{ $class->column_name_width }} py-2 text-left text-black-400"></td>
            <td class="{{ $class->column_value_width }} py-2 text-right text-black-400 text-xs"></td>
            <td class="{{ $class->column_value_width }} py-2 text-right text-black-400 text-xs">
                {{ $deduction['pay_item'] }}
            </td>
            <td class="{{ $class->column_value_width }} py-2 text-right text-black-400 text-xs">
                <x-money :amount="$deduction['amount']" :currency="setting('default.currency')" convert />
            </td>
            <td class="{{ $class->column_value_width }} py-2 text-right text-black-400 text-xs"></td>
            <td class="{{ $class->column_name_width }} py-2 text-right text-black-400 text-xs"></td>
        </tr>
    @endforeach
@endif
