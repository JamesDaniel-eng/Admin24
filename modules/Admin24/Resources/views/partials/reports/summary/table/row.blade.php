<x-table.tr>
    <x-table.td class="w-2/12 col-w-2 py-2 text-left text-left text-black-400 text-sm" override="class">
        {{ $class->row_values[$table_key][$id]['date'] }}
    </x-table.td>
    <x-table.td class="w-2/12 col-w-2 py-2 text-left rtl:text-left text-black-400 text-sm" override="class">
        {{ $class->row_values[$table_key][$id]['name'] }}
    </x-table.td>
    <x-table.td class="w-2/12 col-w-2 py-2 text-center rtl:text-left text-black-400 text-sm" override="class">
        {{ $class->row_values[$table_key][$id]['transfer_quantity'] }}
    </x-table.td>
    <x-table.td class="w-2/12 col-w-2 py-2 text-center rtl:text-left text-black-400 text-sm font-medium" override="class">
        {{ $class->row_values[$table_key][$id]['quantities'] }}
    </x-table.td>
    <x-table.td class="w-2/12 col-w-2 py-2 text-right rtl:text-left text-black-400 text-sm" override="class">
        {{ $class->has_money ? money((int) $class->row_values[$table_key][$id]['purchase_price']) : (int) $class->row_values[$table_key][$id]['purchase_price']}}
    </x-table.td>
    <x-table.td class="w-2/12 col-w-2 py-2 rtl:text-left text-right text-black-400 text-sm font-medium" override="class">
        {{ $class->has_money ? money((int) $class->row_values[$table_key][$id]['total']) : (int) $$class->row_values[$table_key][$id]['total'] }}
    </x-table.td>
</x-table.tr>