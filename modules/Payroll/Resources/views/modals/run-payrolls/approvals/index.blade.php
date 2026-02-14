<x-form.container class="relative lg:w-full z-10" override="class">
    <x-form id="run-payroll" :route="['payroll.pay-calendars.run-payrolls.approvals.update', $payCalendar->id, $runPayroll->id]">
        <x-form.section>
            <x-slot name="body">
                <x-form.group.date name="payment_date" label="{{ trans('payroll::run-payrolls.payment_date') }}" icon="calendar_today" value="{{ $runPayroll->payment_date }}" show-date-format="{{ company_date_format() }}" date-format="Y-m-d" autocomplete="off" form-group-class="sm:col-span-2" />
            </x-slot>
        </x-form.section>

        <x-table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th class="w-4/12 sm:w-2/12">
                        {{ trans('general.name') }}
                    </x-table.th>

                    <x-table.th class="w-4/12 sm:w-2/12">
                        {{ trans_choice('employees::general.departments', 1) }}
                    </x-table.th>

                    <x-table.th class="w-2/12" kind="amount" hidden-mobile>
                        {{ trans_choice('payroll::general.salaries', 1) }}
                    </x-table.th>

                    <x-table.th class="w-2/12" kind="amount" hidden-mobile>
                        {{ trans_choice('payroll::general.benefits', 1) }}
                    </x-table.th>

                    <x-table.th class="w-2/12" kind="amount" hidden-mobile>
                        {{ trans_choice('payroll::general.deductions', 1) }}
                    </x-table.th>

                    <x-table.th class="w-4/12 sm:w-2/12" kind="amount">
                        {{ trans('payroll::general.total', ['type' => trans('general.amount')]) }}
                    </x-table.th>
                </x-table.tr>
            </x-table.thead>

            <x-table.tbody>
                @foreach($employees as $item)
                    @php
                        $empyolee_currency = $item->employee->contact->currency;

                        $main_salary = $main_benefit = $main_deduction = $main_total = null;

                        if ($runPayroll->currency_code != $empyolee_currency->code) {
                            $main_salary = money($item->salary, $empyolee_currency->code, true)->format();
                            $main_benefit = money($item->benefit, $empyolee_currency->code, true)->format();
                            $main_deduction = money($item->deduction, $empyolee_currency->code, true)->format();
                            $main_total = money($item->total, $empyolee_currency->code, true)->format();

                            $item->salary = ($item->salary / $empyolee_currency->rate) * $runPayroll->currency->rate;
                            $item->benefit = ($item->benefit / $empyolee_currency->rate) * $runPayroll->currency->rate;
                            $item->deduction = ($item->deduction / $empyolee_currency->rate) * $runPayroll->currency->rate;
                            $item->total = ($item->total / $empyolee_currency->rate) * $runPayroll->currency->rate;
                        }
                    @endphp
                    <x-table.tr href="{{ route('employees.employees.show', $item->id ) }}">
                        <x-table.td class="w-4/12 sm:w-2/12">
                            {{ $item->employee->contact->name }}
                        </x-table.td>

                        <x-table.td class="w-4/12 sm:w-2/12">
                            {{ $item->employee->department->name }}
                        </x-table.td>

                        <x-table.td class="w-2/12" kind="amount" hidden-mobile>
                            @if ($main_salary)
                                <x-tooltip placement="top" message="{{ $main_salary }}">        
                                    <x-money :amount="$item->salary" :currency="$runPayroll->currency_code" convert />
                                </x-tooltip>
                            @else
                                <x-money :amount="$item->salary" :currency="$runPayroll->currency_code" convert />
                            @endif
                        </x-table.td>

                        <x-table.td class="w-2/12" kind="amount" hidden-mobile>
                            @if ($main_benefit)
                                <x-tooltip placement="top" message="{{ $main_benefit }}">        
                                    <x-money :amount="$item->benefit" :currency="$runPayroll->currency_code" convert />
                                </x-tooltip>
                            @else
                                <x-money :amount="$item->benefit" :currency="$runPayroll->currency_code" convert />
                            @endif
                        </x-table.td>

                        <x-table.td class="w-2/12" kind="amount" hidden-mobile>
                            @if ($main_deduction)
                                <x-tooltip placement="top" message="{{ $main_deduction }}">        
                                    <x-money :amount="$item->deduction" :currency="$runPayroll->currency_code" convert />
                                </x-tooltip>
                            @else
                                <x-money :amount="$item->deduction" :currency="$runPayroll->currency_code" convert />
                            @endif
                        </x-table.td>

                        <x-table.td class="w-4/12 sm:w-2/12" kind="amount">
                            @if ($main_total)
                                <x-tooltip placement="top" message="{{ $main_total }}">        
                                    <x-money :amount="$item->total" :currency="$runPayroll->currency_code" convert />
                                </x-tooltip>
                            @else
                                <x-money :amount="$item->total" :currency="$runPayroll->currency_code" convert />
                            @endif
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table>

        <x-form.section>
            <x-slot name="foot">
                <div class="flex justify-end mt-4">
                    <x-button
                        type="submit"
                        class="relative flex items-center content-end bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
                        ::disabled="form.loading"
                        override="class"
                    >
                        <i v-if="form.loading" class="submit-spin absolute w-3 h-3 rounded-full left-0 right-0 -top-3.5 m-auto"></i>
                        <span :class="[{'opacity-0': form.loading}]">
                            {{ trans('payroll::general.approve') }}
                        </span>
                    </x-button>
                </div>
            </x-slot>
        </x-form.section>
    </x-form>
</x-form.container>