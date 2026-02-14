<x-show.accordion type="journal" :open="false">
    <x-slot name="head">
        <x-show.accordion.head
            :title="trans_choice('double-entry::general.manual_journals', 1)"
            :description="trans('double-entry::general.manual_journal_description')"
        />
    </x-slot>

    <x-slot name="body" class="block" override="class">
        <x-table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th class="w-2/4">
                        {{ trans_choice('general.numbers', 1) }}
                    </x-table.th>

                    <x-table.th class="w-2/4" kind="amount">
                        {{ trans('general.amount') }}
                    </x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                <x-table.tr>
                    <x-table.td class="w-2/4">
                        <x-link href="{{ route('double-entry.journal-entry.show', $journal->id) }}"
                            override="class"
                            class="py-1.5 mb-3 sm:mb-0 text-xs bg-transparent hover:bg-transparent font-medium leading-6"
                        >
                            <x-link.hover>
                                {{ $journal->journal_number }}
                            </x-link.hover>
                        </x-link>
                    </x-table.td>

                    <x-table.td class="w-2/4" kind="amount">
                        <x-money :amount="$journal->amount ?? 0" :currency="$journal->currency_code" convert />
                    </x-table.td>
                </x-table.tr>
            </x-table.tbody>
        </x-table>
    </x-slot>
</x-show.accordion>
