<x-layouts.admin>
    <x-slot name="title">{{ trans_choice('payroll::general.run_payrolls', 2) }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans_choice('payroll::general.run_payrolls', 2) }}"
        icon="groups"
        route="payroll.run-payrolls.index"
    ></x-slot>

    <x-slot name="buttons">
        @can('create-payroll-run-payrolls')
            <x-link href="{{ route('import.create', ['payroll', 'run-payrolls']) }}">
                {{ trans('import.import') }}
            </x-link>
        @endcan

        <x-link href="{{ route('payroll.run-payrolls.export', request()->input()) }}">
            {{ trans('general.export') }}
        </x-link>
    </x-slot>

    <x-slot name="content">
        @if ($payrolls->count() || request()->get('search', false))
            <x-index.container>
                <x-index.search
                    search-string="Modules\Payroll\Models\RunPayroll\RunPayroll"
                    bulk-action="Modules\Payroll\BulkActions\RunPayrolls"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr>
                            <x-table.th kind="bulkaction">
                                <x-index.bulkaction.all />
                            </x-table.th>

                            <x-table.th class="w-4/12 sm:w-3/12">
                                <x-slot name="first">
                                    <x-sortablelink column="payment_date" title="{{ trans_choice('payroll::run-payrolls.payment_date', 1) }}" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="name" title="{{ trans_choice('general.numbers', 1) }}" />
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-4/12 sm:w-3/12">
                                <x-slot name="first">
                                    <x-sortablelink column="from_date" title="{{ trans('payroll::run-payrolls.from_date') }}" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="to_date" title="{{ trans('payroll::run-payrolls.to_date') }}" />
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-2/12" hidden-mobile>
                                {{ trans_choice('payroll::general.employees', 2) }}
                            </x-table.th>

                            <x-table.th class="w-2/12" hidden-mobile>
                                <x-sortablelink column="status" title="{{ trans_choice('general.statuses', 1) }}" />
                            </x-table.th>

                            <x-table.th class="w-4/12 sm:w-2/12" kind="amount">
                                <x-sortablelink column="amount" title="{{ trans('general.amount') }}" />
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach($payrolls as $item)
                            <x-table.tr href="{{ route('payroll.run-payrolls.edit', $item->id) }}">
                                <x-table.td kind="bulkaction">
                                    <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->name }}" />
                                </x-table.td>

                                <x-table.td class="w-4/12 sm:w-3/12 truncate">
                                    <x-slot name="first" class="flex items-center font-bold" override="class">
                                        <x-date date="{{ $item->payment_date }}" />
                                    </x-slot>
                                    <x-slot name="second" class="font-normal truncate" override="class">
                                        {{ $item->name }}
                                    </x-slot>
                                </x-table.td>

                                <x-table.td class="w-4/12 sm:w-3/12 truncate">
                                    <x-slot name="first" class="flex items-center font-bold" override="class">
                                        <x-date date="{{ $item->from_date }}" />
                                    </x-slot>
                                    <x-slot name="second" class="font-normal truncate" override="class">
                                        <x-date date="{{ $item->to_date }}" />
                                    </x-slot>
                                </x-table.td>

                                <x-table.td class="w-2/12 truncate" hidden-mobile>
                                    {{ $item->employees->count() }}
                                </x-table.td>

                                <x-table.td class="w-2/12 text-left" hidden-mobile>
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-xl bg-{{ $item->status_label }} text-text-{{ $item->status_label }}">
                                        {{ trans('payroll::run-payrolls.status.' . $item->status) }}
                                    </span>
                                </x-table.td>

                                <x-table.td class="w-4/12 sm:w-2/12 text-left" kind="amount">
                                    <x-money :amount="$item->amount" :currency="$item->currency_code" convert />
                                </x-table.td>

                                <x-table.td kind="action">
                                    <x-table.actions :model="$item" />
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.tbody>
                </x-table>

                <x-pagination :items="$payrolls" />
            </x-index.container>
        @else
            <x-empty-page group="payroll" page="run-payrolls" docs-category="hr" hide-button-create="true" />
        @endif
    </x-slot>

    <x-script alias="payroll" file="pay-calendars" />
</x-layouts.admin>
