<x-table.tr class="border-b border-gray-300 border-bottom-1" override="class">
    <x-table.td class="w-10/12 ltr:text-left rtl:text-right text-black-400 text-alignment-left pt-5" override="class">
        <div class="flex items-center">
            {{ trans($type->name) }}

            @if (! isset($print))
                <button type="button" class="flex items-center mt-1 leading-none align-text-top" onClick="toggleSub('type-{{ $type->id }}', event)">
                    <span class="material-icons transform transition-all text-lg leading-none">navigate_next</span>
                </button> 
            @endif
        </div>
    </x-table.td>
    <x-table.td class="w-2/12 ltr:text-right rtl:text-left text-black-400 text-xs text-alignment-right pt-5" override="class">
        <x-money :amount="$type->total" :currency="default_currency()" convert />
    </x-table.td>
</x-table.tr>
@foreach($class->de_accounts[$type->id] as $account)
    @if ($class->general_ledger_report && $class->general_ledger_report->id && $account->id)
    <x-table.tr href="{{ route('reports.show', [$class->general_ledger_report->id]) }}?search=de_account_id:{{ $account->id }}" data-collapse="type-{{ $type->id }}" class="active-collapse" override="class">
        <x-table.td class="w-10/12 ltr:text-left rtl:text-right text-black-400 pl-5 print-report-padding text-sm" override="class" data-account-code="{{ $account->code }}">
            <span class="to-black-400 hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize cursor-pointer inline-block">
                @if ($account->code)
                    {{ $account->code }} - {{ $account->trans_name }}
                @else
                    {{ $account->trans_name }}
                @endif
            </span>
        </x-table.td>
        <x-table.td class="w-2/12 ltr:text-right rtl:text-left text-black-400 text-xs text-alignment-right text-sm" override="class">
            <x-money :amount="$account->de_balance" :currency="default_currency()" convert />
        </x-table.td>
    </x-table.tr>
    @else
    <x-table.tr data-collapse="type-{{ $type->id }}" class="active-collapse" override="class">
        <x-table.td class="w-10/12 ltr:text-left rtl:text-right text-black-400 pl-5 print-report-padding text-sm" override="class" data-account-code="{{ $account->code }}">
            @if($account->code)
                {{ $account->code }} - {{ $account->trans_name }}
            @else
                {{ $account->trans_name }}
            @endif
        </x-table.td>
        <x-table.td class="w-2/12 ltr:text-right rtl:text-left text-black-400 text-xs text-alignment-right" override="class">
            <x-money :amount="$account->de_balance" :currency="default_currency()" convert />
        </x-table.td>
    </x-table.tr>
    @endif
@endforeach
