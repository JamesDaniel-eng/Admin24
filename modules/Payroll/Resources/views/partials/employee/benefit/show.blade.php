<div class="sm:col-span-12">
    <x-table>
        @if ($employee->benefits->count())
            <x-table.thead>
                <x-table.tr class="flex items-center px-1">
                    <x-table.th class="w-4/12">
                        {{ trans_choice('general.types', 1) }}
                    </x-table.th>

                    <x-table.th class="w-4/12">
                        {{ trans('recurring.recurring') }}
                    </x-table.th>

                    <x-table.th class="w-4/12" kind="amount">
                        {{ trans('general.amount') }}
                    </x-table.th>
                </x-table.tr>
            </x-table.thead>

            <x-table.tbody>
                @foreach($employee->benefits as $benefit)
                    <x-table.tr>
                        <x-table.td class="w-4/12">
                            {{ $benefit->pay_item->pay_item }}
                        </x-table.td>

                        <x-table.td class="w-4/12">
                            {{ trans('payroll::benefits.benefit_recurring.' . $benefit->recurring) }}
                        </x-table.td>

                        <x-table.td class="w-4/12" kind="amount">
                            <x-money :amount="$benefit->amount" :currency="$benefit->currency_code" convert />
                        </x-table.td>

                        <x-table.td class="p-0" override="class">
                            <div class="absolute ltr:right-12 rtl:left-12 -top-4 hidden items-center group-hover:flex">
                                <a @click="onShowBenefit({{ $benefit->id }}, '{{ trans_choice('payroll::general.benefits', 1) }}')" href="javascript:void(0);" class="relative bg-white hover:bg-gray-100 border py-0.5 px-1 cursor-pointer index-actions group">
                                    <span class="material-icons-outlined text-purple text-lg">visibility</span>
                                    <div class="inline-block absolute invisible z-20 py-1 px-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 tooltip-content -top-10 -left-2" data-tooltip-placement="top">
                                        <span>{{ trans('general.show') }}</span>
                                        <div class="w-2 h-2 tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </a>

                                <a @click="onModalAddNew('{{ route('payroll.modals.payroll.employee.benefit.modal.edit', $benefit->id) }}')" href="javascript:void(0);" class="relative bg-white hover:bg-gray-100 border py-0.5 px-1 cursor-pointer index-actions group">
                                    <span class="material-icons-outlined text-purple text-lg">edit</span>
                                    <div class="inline-block absolute invisible z-20 py-1 px-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 tooltip-content -top-10 -left-2" data-tooltip-placement="top">
                                        <span>{{ trans('general.edit') }}</span>
                                        <div class="w-2 h-2 tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </a>

                                @php($benefit->pay_item_name = $benefit->pay_item->pay_item)    
                                
                                <x-delete-button :model="$benefit" route="payroll.modals.payroll.employee.benefit.destroy" :title="trans_choice('payroll::general.benefits', 1)" />
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        @else
            <x-table.td class="w-12/12">
                {{ trans('general.no_records') }}
            </x-table.td>
        @endif
    </x-table>
</div>
