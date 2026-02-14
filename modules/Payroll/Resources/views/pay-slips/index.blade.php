<x-layouts.admin>
    <x-slot name="title">{{ trans_choice('payroll::general.pay_slips', 2) }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans_choice('payroll::general.pay_slips', 2) }}"
        icon="groups"
        route="payroll.pay-slips.index"
    ></x-slot>

    <x-slot name="content">
        @if ($pay_slips->count() || request()->get('search', false))
            <x-index.container>
                <x-index.search
                    search-string="Modules\Payroll\Models\RunPayroll\RunPayroll"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr>
                            <x-table.th class="w-8/12 sm:w-4/12">
                                <x-slot name="first">
                                    {{ trans('general.date') }}
                                </x-slot>
                                <x-slot name="second">
                                    {{ trans('general.number') }}
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-4/12" kind="amount" hidden-mobile>
                                <x-slot name="first">
                                    {{ trans('payroll::general.total', ['type' => trans_choice('payroll::general.benefits', 1)]) }}
                                </x-slot>
                                <x-slot name="second">
                                    {{ trans('payroll::general.total', ['type' => trans_choice('payroll::general.deductions', 1)]) }}
                                </x-slot>
                            </x-table.th>
        
                            <x-table.th class="w-2/12" kind="amount">
                                {{ trans_choice('payroll::general.salaries', 1) }}
                            </x-table.th>
        
                            <x-table.th class="w-2/12" kind="amount">
                                {{ trans_choice('general.totals', 1) }}
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach($pay_slips as $pay_slip)
                            @php
                                $more_actions = [
                                    [
                                        'title' => trans('general.show'),
                                        'icon' => 'visibility',
                                        'url' => route('payroll.pay-slips.show', $pay_slip->id),
                                        'permission' => 'read-payroll-pay-slips',
                                    ],
                                ];
                            @endphp
                            <x-table.tr href="{{ route('payroll.pay-slips.show', $pay_slip->id) }}">
                                <x-table.td class="w-8/12 sm:w-4/12">
                                    <x-slot name="first" class="flex font-bold" override="class">
                                        <x-date date="{{ $pay_slip->run_payroll->payment_date }}" />
                                    </x-slot>
                                    <x-slot name="second" class="font-normal" override="class">
                                        {{ $pay_slip->run_payroll->name }}
                                    </x-slot>
                                </x-table.td>

                                <x-table.td class="w-4/12" kind="amount" hidden-mobile>
                                    <x-slot name="first">
                                        <x-money :amount="$pay_slip->benefit" :currency="$pay_slip->run_payroll->currency_code" convert />
                                    </x-slot>
                                    <x-slot name="second">
                                        <x-money :amount="$pay_slip->deduction" :currency="$pay_slip->run_payroll->currency_code" convert />
                                    </x-slot>
                                </x-table.td>

                                <x-table.td class="w-2/12" kind="amount">
                                    <x-money :amount="$pay_slip->salary" :currency="$pay_slip->run_payroll->currency_code" convert />
                                </x-table.td>

                                <x-table.td class="w-2/12" kind="amount">
                                    <x-money :amount="$pay_slip->total" :currency="$pay_slip->run_payroll->currency_code" convert />
                                </x-table.td>

                                <x-table.td kind="action">
                                    <x-table.actions :actions="$more_actions" />
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.tbody>
                </x-table>

                {{-- <x-pagination :items="$payrolls" /> --}}
            </x-index.container>
        @else
            <x-empty-page group="payroll" page="pay-slips" docs-category="hr" hide-button-create="true" hide-button-import="true" />
        @endif
    </x-slot>

    <x-script alias="payroll" file="pay-calendars" />
</x-layouts.admin>
