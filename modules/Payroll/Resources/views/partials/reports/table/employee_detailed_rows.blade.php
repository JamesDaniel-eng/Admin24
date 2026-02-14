@if ($row_total = array_sum($rows))
    <tr class="row rp-border-top-1 font-size-unset">
        <td class="{{ $class->column_name_width }} long-texts pr-0">{{ $class->row_names[$table][$id] }}</td>
        @foreach($rows as $row_id => $row)
            @if($row_id !== 'benefits' && $row_id !== 'deductions')
                <td class="{{ $class->column_value_width }} text-right px-0">
                    @if(is_numeric($row))
                        <x-money :amount="$row" :currency="setting('default.currency')" convert />
                    @endif
                </td>
            @endif
        @endforeach
        <td class="{{ $class->column_name_width }} text-right pl-0 pr-4">
            <x-money :amount="$row_total" :currency="setting('default.currency')" convert />
        </td>
    </tr>
    @foreach($rows['benefits'] as $benefit)
        <tr class="row rp-border-top-1 font-size-unset">
            <td class="{{ $class->column_name_width }} long-texts pr-0"></td>
            <td class="{{ $class->column_value_width }} text-right px-0"></td>
            <td class="{{ $class->column_value_width }} text-right px-0">
                {{ $benefit['pay_item'] }}
            </td>
            <td class="{{ $class->column_value_width }} text-right px-0">
                <x-money :amount="$benefit['amount']" :currency="setting('default.currency')" convert />
            </td>
            <td class="{{ $class->column_value_width }} text-right px-0"></td>
            <td class="{{ $class->column_value_width }} text-right px-0"></td>
            <td class="{{ $class->column_name_width }} text-right pl-0 pr-4"></td>
        </tr>
    @endforeach
    @foreach($rows['deductions'] as $deduction)
        <tr class="row rp-border-top-1 font-size-unset">
            <td class="{{ $class->column_name_width }} long-texts pr-0"></td>
            <td class="{{ $class->column_value_width }} text-right px-0"></td>
            <td class="{{ $class->column_value_width }} text-right px-0"></td>
            <td class="{{ $class->column_value_width }} text-right px-0"></td>
            <td class="{{ $class->column_value_width }} text-right px-0">
                {{ $deduction['pay_item'] }}
            </td>
            <td class="{{ $class->column_value_width }} text-right px-0">
                <x-money :amount="-$deduction['amount']" :currency="setting('default.currency')" convert />
            </td>
            <td class="{{ $class->column_name_width }} text-right pl-0 pr-4"></td>
        </tr>
    @endforeach
@endif
