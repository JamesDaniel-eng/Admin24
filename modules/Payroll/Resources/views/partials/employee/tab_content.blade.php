{{-- <component v-bind:is="component"></component> --}}

<div class="w-full lg:w-12/12 flex items-center mt-12">
    @stack('summary_total_start')
        <div class="w-1/2 sm:w-1/3 text-center">
            <x-tooltip id="total_payment" placement="top" message="{!! $summary_amounts['total_exact'] !!}">
                <div class="relative text-xl sm:text-6xl text-purple group-hover:text-purple-700 mb-2">
                    {!! $summary_amounts['total_for_humans'] !!}
                    <span class="w-8 absolute left-0 right-0 m-auto -bottom-1 bg-gray-200 transition-all group-hover:bg-gray-900" style="height: 1px;"></span>
                </div>

                <span class="font-light mt-3">
                    {{ trans('payroll::general.total', ['type' => trans('invoices.payments')]) }}
                </span>
            </x-tooltip>
        </div>
    @stack('summary_total_end')

    @stack('summary_benefit_start')
        <div class="w-1/2 sm:w-1/3 text-center">
            <x-tooltip id="total_benefit" placement="top" message="{!! $summary_amounts['benefit_exact'] !!}">
                <div class="relative text-xl sm:text-6xl text-purple group-hover:text-purple-700 mb-2">
                    {!! $summary_amounts['benefit_for_humans'] !!}
                    <span class="w-8 absolute left-0 right-0 m-auto -bottom-1 bg-gray-200 transition-all group-hover:bg-gray-900" style="height: 1px;"></span>
                </div>

                <span class="font-light mt-3">
                    {{ trans('payroll::general.total', ['type' => trans_choice('payroll::general.benefits', 1)]) }}
                </span>
            </x-tooltip>
        </div>
    @stack('summary_benefit_end')

    @stack('summary_deduction_start')
        <div class="w-1/2 sm:w-1/3 text-center">
            <x-tooltip id="total_deduction" placement="top" message="{!! $summary_amounts['deduction_exact'] !!}">
                <div class="relative text-xl sm:text-6xl text-purple group-hover:text-purple-700 mb-2">
                    {!! $summary_amounts['deduction_for_humans'] !!}
                    <span class="w-8 absolute left-0 right-0 m-auto -bottom-1 bg-gray-200 transition-all group-hover:bg-gray-900" style="height: 1px;"></span>
                </div>

                <span class="font-light mt-3">
                    {{ trans('payroll::general.total', ['type' => trans_choice('payroll::general.deductions', 1)]) }}
                </span>
            </x-tooltip>
        </div>
    @stack('summary_deduction_end')
</div>

<div class="form-body__desc border-b-2 border-gray-200 mt-10 flex items-center">
    <h2 class="lg:text-lg mb-3">
        {{ trans('payroll::employees.payment_histories') }}
    </h2>
</div>

<div class="sm:col-span-12">
    @if ($payments->count())
        <x-table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th class="w-4/12 sm:w-2/12">
                        {{ trans('general.date') }}
                    </x-table.th>

                    <x-table.th class="w-6/12 sm:w-2/12">
                        {{ trans('general.name') }}
                    </x-table.th>

                    <x-table.th class="w-2/12" kind="amount" hidden-mobile>
                        {{ trans('payroll::general.total', ['type' => trans_choice('payroll::general.benefits', 1)]) }}
                    </x-table.th>

                    <x-table.th class="w-2/12" kind="amount" hidden-mobile>
                        {{ trans('payroll::general.total', ['type' => trans_choice('payroll::general.deductions', 1)]) }}
                    </x-table.th>

                    <x-table.th class="w-2/12" kind="amount" hidden-mobile>
                        {{ trans_choice('payroll::general.salaries', 1) }}
                    </x-table.th>

                    <x-table.th class="w-2/12" kind="amount">
                        {{ trans_choice('general.totals', 1) }}
                    </x-table.th>
                </x-table.tr>
            </x-table.thead>

            <x-table.tbody>
                @foreach($payments as $payment)
                    @php
                        $empyolee_currency = $payment->employee->contact->currency;

                        $main_salary = $main_benefit = $main_deduction = $main_total = null;

                        if ($payment->run_payroll->currency_code != $empyolee_currency->code) {
                            $main_salary = money($payment->salary, $empyolee_currency->code, true)->format();
                            $main_benefit = money($payment->benefit, $empyolee_currency->code, true)->format();
                            $main_deduction = money($payment->deduction, $empyolee_currency->code, true)->format();
                            $main_total = money($payment->total, $empyolee_currency->code, true)->format();

                            $payment->salary = ($payment->salary / $empyolee_currency->rate) * $payment->run_payroll->currency->rate;
                            $payment->benefit = ($payment->benefit / $empyolee_currency->rate) * $payment->run_payroll->currency->rate;
                            $payment->deduction = ($payment->deduction / $empyolee_currency->rate) * $payment->run_payroll->currency->rate;
                            $payment->total = ($payment->total / $empyolee_currency->rate) * $payment->run_payroll->currency->rate;
                        }
                    @endphp
                    <x-table.tr>
                        <x-table.td class="w-4/12 sm:w-2/12">
                            <x-date date="{{ $payment->run_payroll->payment_date }}" />
                        </x-table.td>

                        <x-table.td class="w-6/12 sm:w-2/12">
                            {{ $payment->run_payroll->name }}
                        </x-table.td>

                        <x-table.td class="w-2/12" kind="amount" hidden-mobile>
                            @if ($main_benefit)
                                <x-tooltip placement="top" message="{{ $main_benefit }}">        
                                    <x-money :amount="$payment->benefit" :currency="$payment->run_payroll->currency_code" convert />
                                </x-tooltip>
                            @else
                                <x-money :amount="$payment->benefit" :currency="$payment->run_payroll->currency_code" convert />
                            @endif
                        </x-table.td>

                        <x-table.td class="w-2/12" kind="amount" hidden-mobile>
                            @if ($main_deduction)
                                <x-tooltip placement="top" message="{{ $main_deduction }}">        
                                    <x-money :amount="$payment->deduction" :currency="$payment->run_payroll->currency_code" convert />
                                </x-tooltip>
                            @else
                                <x-money :amount="$payment->deduction" :currency="$payment->run_payroll->currency_code" convert />
                            @endif
                        </x-table.td>

                        <x-table.td class="w-2/12" kind="amount" hidden-mobile>
                            @if ($main_salary)
                                <x-tooltip placement="top" message="{{ $main_salary }}">        
                                    <x-money :amount="$payment->salary" :currency="$payment->run_payroll->currency_code" convert />
                                </x-tooltip>
                            @else
                                <x-money :amount="$payment->salary" :currency="$payment->run_payroll->currency_code" convert />
                            @endif
                        </x-table.td>

                        <x-table.td class="w-2/12" kind="amount">
                            @if ($main_total)
                                <x-tooltip placement="top" message="{{ $main_total }}">        
                                    <x-money :amount="$payment->total" :currency="$payment->run_payroll->currency_code" convert />
                                </x-tooltip>
                            @else
                                <x-money :amount="$payment->total" :currency="$payment->run_payroll->currency_code" convert />
                            @endif
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table>

        <x-pagination :items="$payments" />
    @else
        <x-show.no-records :url="route('payroll.pay-calendars.create')" :text-action="trans('general.title.new', ['type' => trans_choice('payroll::general.pay_calendars', 1)])" image="modules/Payroll/Resources/assets/img/empty-pay-calendars.png" :description="trans('payroll::general.no_records.employee')" />
    @endif
</div>

<div class="flex mt-12">
    <div class="w-6/12 mr-3">
        <div class="border-b-2 border-gray-200 mb-2 grid gap-2 grid-cols-2 items-center">
            <h2 class="lg:text-lg mb-3">
                {{ trans_choice('payroll::general.benefits', 1) }}
            </h2>

            <div class="flex justify-end mb-3">
                <x-button
                    type="button"
                    id="button-benefit"
                    class="relative bg-green hover:bg-green-700 text-white px-2 py-1 text-base rounded-lg disabled:bg-green-100"
                    override="class"
                    @click="onModalAddNew('{{ route('payroll.modals.employees.benefit.create', $employee->id) }}')"
                >
                    <span>{{ trans('general.add_new') }}</span>
                </x-button>
            </div>
        </div>

        @include('payroll::partials.employee.benefit.show')
    </div>

    <div class="w-6/12 ml-3">
        <div class="form-body__desc border-b-2 border-gray-200 mb-2 grid gap-2 grid-cols-2 items-center">
            <h2 class="lg:text-lg mb-3">
                {{ trans_choice('payroll::general.deductions', 1) }}
            </h2>

            <div class="flex justify-end mb-3">
                <x-button
                    type="button"
                    id="button-deductions"
                    class="relative bg-green hover:bg-green-700 text-white px-2 py-1 text-base rounded-lg disabled:bg-green-100"
                    override="class"
                    @click="onModalAddNew('{{ route('payroll.modals.employees.deduction.create', $employee->id) }}')"
                >
                    <span>{{ trans('general.add_new') }}</span>
                </x-button>
            </div>
        </div>

        @include('payroll::partials.employee.deduction.show')
    </div>
</div>

<component v-bind:is="show_benefit_html"></component>
<component v-bind:is="show_deduction_html"></component>
