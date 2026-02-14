<x-table.thead>
    <x-table.tr class="relative flex items-center px-2 group border-b hover:bg-gray-100 text-alignment-left" override="class">
        <x-table.th class="w-2/12 col-w-2 py-2 text-left text-left text-black-400 text-xs font-bold uppercase" override="class" >
            {{ trans_choice('admin24::reports.date', 2) }}
        </x-table.th>
        <x-table.th class="w-2/12 col-w-2 py-2 text-left rtl:text-left text-black-400 text-xs font-medium uppercase" override="class">
            {{ trans_choice('admin24::reports.item_name', 2) }}
        </x-table.th>
        <x-table.th class="w-2/12 col-w-2 py-2 text-center rtl:text-left text-black-400 text-xs font-medium uppercase" override="class">
            {{ trans_choice('admin24::reports.transfer_quantity', 2) }}
        </x-table.th>
        <x-table.th class="w-2/12 col-w-2 py-2 text-center rtl:text-left text-black-400 text-xs font-medium uppercase" override="class">
            {{ trans_choice('admin24::settings.produces', 2) }}
        </x-table.th>
        <x-table.th class="w-2/12 col-w-2 py-2 text-right rtl:text-left text-black-400 text-xs font-medium uppercase" override="class">
            {{ trans_choice('admin24::reports.purchase_price', 2) }}
        </x-table.th>
        <x-table.th class="w-2/12 col-w-2 py-2 text-right rtl:text-left text-black-400 text-xs font-medium uppercase" override="class">
            {{ trans_choice('admin24::reports.total', 2) }}
        </x-table.th>
    </x-table.tr>
</x-table.thead>