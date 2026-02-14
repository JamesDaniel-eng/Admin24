<x-show.accordion type="transaction" :open="false">
    <x-slot name="head">
        <x-show.accordion.head
            :title="trans_choice('general.transactions', 2)"
            :description="trans('double-entry::general.transaction_description')"
        />
    </x-slot>

    <x-slot name="body" class="block" override="class">
        <x-table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th class="w-2/4">
                        {{ trans_choice('general.numbers', 1) }}
                    </x-table.th>

                    <x-table.th class="w-1/4" kind="amount">
                        {{ trans_choice('general.incomes', 1) }}
                    </x-table.th>

                    <x-table.th class="w-1/4" kind="amount">
                        {{ trans_choice('general.expenses', 1) }}
                    </x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach ($journal->ledgers as $ledger)
                    @if ($ledger->transaction_id === null || ! $ledger->transaction)
                        @continue
                    @endif
                    <x-table.tr>
                        <x-table.td class="w-2/4">
                            <x-link href="{{ route('transactions.show', $ledger->transaction_id) }}"
                                override="class"
                                class="py-1.5 mb-3 sm:mb-0 text-xs bg-transparent hover:bg-transparent font-medium leading-6"
                            >
                                <x-link.hover>
                                    {{ $ledger->transaction->number }}
                                </x-link.hover>
                            </x-link>
                        </x-table.td>

                        @if ($ledger->transaction->type === 'income')
                            <x-table.td class="w-1/4" kind="amount">
                                <x-money :amount="$ledger->transaction->amount ?? 0" :currency="$ledger->transaction->currency_code" convert />
                            </x-table.td>
                        @else
                            <x-table.td class="w-1/4" kind="amount">
                            </x-table.td>
                        @endif

                        @if ($ledger->transaction->type === 'expense')
                            <x-table.td class="w-1/4" kind="amount">
                                <x-money :amount="$ledger->transaction->amount ?? 0" :currency="$ledger->transaction->currency_code" convert />
                            </x-table.td>
                        @else
                            <x-table.td class="w-1/4" kind="amount">
                            </x-table.td>
                        @endif
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table>
    </x-slot>
</x-show.accordion>
