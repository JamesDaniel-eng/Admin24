@php 
    $grand_total = 0;
    if(!empty($class->row_values[$table_key])){
        foreach($class->row_values[$table_key] as $item){
            $total = $item['total'];
            $grand_total += $total;
        }   
    }         
@endphp

<tfoot>
    @if (!empty($class->row_values[$table_key]))
        <x-table.tr class="relative flex items-center px-2 py-5 group border-t hover:bg-gray-100 text-alignment-left" override="class">
            <x-table.td class="w-9/12 col-w-2 py-2 text-left text-black-400 text-lg font-bold uppercase" override="class" >
                {{ trans_choice('general.totals', 1) }}
            </x-table.td>
            <x-table.td class="w-3/12 col-w-2 py-2 text-right rtl:text-left text-black-400 text-lg font-bold" override="class">
                {{ $class->has_money ? money($grand_total) : $grand_total }}
            </x-table.td>
        </x-table.tr>
    @else
        <x-table.tr class="relative flex items-center px-2 py-5 group border-t hover:bg-gray-100 text-alignment-left" override="class">
            <x-table.td class="w-12/12 col-w-2 py-2 text-right text-black-400 text-lg font-bold uppercase" override="class" >
                <div class="text-muted pl-0">{{ trans('admin24::reports.no_total') }}</div>
            </x-table.td>
        </x-table.tr>
    @endif
</tfoot>
