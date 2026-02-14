<x-table.thead>
    <x-table.tr class="border-b border-purple border-bottom-1">
        <x-table.th class="ltr:text-left rtl:text-right text-xl text-purple font-bold pt-8 text-alignment-left" override="class" colspan="6">
            {{ $table_name }}
        </x-table.th>
    </x-table.tr>
    <x-table.tr class="relative flex items-center px-1 group border-b hover:bg-gray-100 text-alignment-left" override="class">
        <x-table.th class="w-10/12 ltr:text-left rtl:text-right text-black-400 font-bold py-2" override="class" colspan="4">
            {{ trans('accounts.opening_balance') }}
        </x-table.th>
        <x-table.th class="w-2/12 ltr:text-right rtl:text-left text-black-400 font-medium text-xs py-2 text-alignment-right" override="class">
            <x-money :amount="$class->opening_balances[$table_key] ?? 0" :currency="default_currency()" convert />
        </x-table.th>
    </x-table.tr>
    <x-table.tr class="relative flex items-center px-1 group border-b hover:bg-gray-100 text-alignment-left" override="class">
        <x-table.th class="w-2/12 ltr:text-left rtl:text-right text-black-400 font-bold py-2 cursor-pointer hover:bg-gray-200 transition sortable" override="class" data-sort-type="general-ledger" data-sort-column="date">
            <div class="flex items-center justify-between">
                {{ trans('general.date') }}
                <svg class="sort-indicator h-5 w-5 text-gray-400 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path class="sort-up" fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3z" clip-rule="evenodd" style="opacity: 0.3;"></path>
                    <path class="sort-down" fill-rule="evenodd" d="M10 17a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 17z" clip-rule="evenodd" style="opacity: 1;"></path>
                </svg>
            </div>
        </x-table.th>
        <x-table.th class="w-2/12 ltr:text-left rtl:text-right text-black-400 font-bold py-2 cursor-pointer hover:bg-gray-200 transition sortable" override="class" data-sort-type="general-ledger" data-sort-column="relation">
            <div class="flex items-center justify-between">
                {{ trans_choice('double-entry::general.relations', 1) }}
                <svg class="sort-indicator h-5 w-5 text-gray-400 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path class="sort-up" fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3z" clip-rule="evenodd" style="opacity: 0.3;"></path>
                    <path class="sort-down" fill-rule="evenodd" d="M10 17a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 17z" clip-rule="evenodd" style="opacity: 1;"></path>
                </svg>
            </div>
        </x-table.th>
        <x-table.th class="w-4/12 ltr:text-left rtl:text-right text-black-400 font-bold py-2 cursor-pointer hover:bg-gray-200 transition sortable" override="class" data-sort-type="general-ledger" data-sort-column="description">
            <div class="flex items-center justify-between">
                Description
                <svg class="sort-indicator h-5 w-5 text-gray-400 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path class="sort-up" fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3z" clip-rule="evenodd" style="opacity: 0.3;"></path>
                    <path class="sort-down" fill-rule="evenodd" d="M10 17a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 17z" clip-rule="evenodd" style="opacity: 1;"></path>
                </svg>
            </div>
        </x-table.th>
        <x-table.th class="w-2/12 ltr:text-right rtl:text-left text-black-400 font-bold py-2 cursor-pointer hover:bg-gray-200 transition sortable" override="class" data-sort-type="general-ledger" data-sort-column="debit">
            <div class="flex items-center justify-end">
                {{ trans_choice('double-entry::general.debits', 1) }}
                <svg class="sort-indicator h-5 w-5 text-gray-400 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path class="sort-up" fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3z" clip-rule="evenodd" style="opacity: 0.3;"></path>
                    <path class="sort-down" fill-rule="evenodd" d="M10 17a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 17z" clip-rule="evenodd" style="opacity: 1;"></path>
                </svg>
            </div>
        </x-table.th>
        <x-table.th class="w-2/12 ltr:text-right rtl:text-left text-black-400 font-bold py-2 cursor-pointer hover:bg-gray-200 transition sortable" override="class" data-sort-type="general-ledger" data-sort-column="credit">
            <div class="flex items-center justify-end">
                {{ trans_choice('double-entry::general.credits', 1) }}
                <svg class="sort-indicator h-5 w-5 text-gray-400 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path class="sort-up" fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3z" clip-rule="evenodd" style="opacity: 0.3;"></path>
                    <path class="sort-down" fill-rule="evenodd" d="M10 17a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 17z" clip-rule="evenodd" style="opacity: 1;"></path>
                </svg>
            </div>
        </x-table.th>
        <x-table.th class="w-2/12 ltr:text-right rtl:text-left text-black-400 font-bold py-2" override="class">
            {{ trans('general.balance') }}
        </x-table.th>
    </x-table.tr>
</x-table.thead>