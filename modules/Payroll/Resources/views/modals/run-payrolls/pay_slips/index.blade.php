<x-form.container class="relative lg:w-full z-10" override="class">
    <x-form id="run-payroll" :route="['payroll.pay-calendars.run-payrolls.pay-slips.post', $payCalendar->id, $runPayroll->id]">
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-4/12 space-y-6">
                <akaunting-select
                    :title="'{{ trans_choice('payroll::general.employees', 1) }}'"
                    :placeholder="'{{ trans('general.form.select.field', ['field' => trans_choice('payroll::general.employees', 1)]) }}'"
                    :name="'employee'"
                    :options="{{ json_encode($employees) }}"
                    :value="'{{ old('employee') }}'"
                    @interface="form.employee = $event"
                    @change="onChangePaySlipEmployee"
                    not-required
                ></akaunting-select>

                <input type="hidden" id="pay_calendar_id" name="pay_calendar_id" value="{{ $payCalendar->id }}">
                <input type="hidden" id="run_payroll_id" name="run_payroll_id" value="{{ $runPayroll->id }}">

                <div class="flex flex-wrap space-x-3 rtl:space-x-reverse">
                    <x-button 
                        kind="secondary"
                        ::disabled="!form.employee"
                        @click="onPrintPaySlipEmployee"
                    >
                        {{ trans('general.print') }}
                    </x-button>

                    <div v-if="form.employee && ! pay_slips.employee.email">
                        <x-tooltip id="tooltip-reconcile" placement="top" message="{{ trans('payroll::messages.not_found_email') }}">
                            <x-button
                                kind="secondary"
                                ::disabled="!pay_slips.employee.email"
                                @click="onSentPaySlipEmployee('{{ trans('general.title.send', ['type' => trans_choice('payroll::general.pay_slips', 1)]) }}')"
                            >
                                {{ trans('general.send') }}
                            </x-button>
                        </x-tooltip>
                    </div>

                    <div v-else>                     
                        <x-button
                            kind="secondary"
                            ::disabled="!pay_slips.employee.email"
                            @click="onSentPaySlipEmployee('{{ trans('general.title.send', ['type' => trans_choice('payroll::general.pay_slips', 1)]) }}')"
                        >
                            {{ trans('general.send') }}
                        </x-button>
                    </div>
                </div>

                <div class="rounded-xl px-5 py-3 mb-5 bg-blue-100" v-if="pay_slips.employee.isMainCurrency==true">
                    <p class="text-sm mb-0 text-blue-600">
                        {{ trans('payroll::run-payrolls.warning.employee_main_currency') }}
                        <dl class="sm:col-span-6 border-b border-gray-200 divide-y divide-gray-200 mt-4">
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-blue-500">
                                    {{ trans_choice('payroll::general.salaries', 1) }}
                                </dt>
        
                                <dd class="text-blue-900" v-html="pay_slips.employee.mainCurrencySalary"></dd>
                            </div>
            
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-blue-500">
                                    {{ trans_choice('payroll::general.benefits', 1) }}
                                </dt>
            
                                <dd class="text-blue-900" v-html="pay_slips.employee.mainCurrencyBenefitAmount"></dd>
                            </div>
            
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-blue-500">
                                    {{ trans_choice('payroll::general.deductions', 1) }}
                                </dt>
            
                                <dd class="text-blue-900" v-html="pay_slips.employee.mainCurrencyDeductionAmount"></dd>
                            </div>
            
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-blue-500">
                                    {{ trans('payroll::general.total', ['type' => trans('general.amount')]) }}
                                </dt>
            
                                <dd class="text-blue-900" v-html="pay_slips.employee.mainCurrencyTotalAmount"></dd>
                            </div>
                        </dl>
                    </p>
                </div>
            </div>

            <div class="lg:w-8/12 lg:pl-12">
                <div class="print-content p-7 shadow-2xl rounded-2xl">
                    <div class="row">
                        <div class="col-100">
                            <div class="text text-dark">
                                <h3>
                                    {{ trans_choice('payroll::general.pay_slips', 1) }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-58">
                            <div class="text">
                                <img src="{{ $logo }}" height="70" width="70" alt="{{ setting('company.name') }}" />
                            </div>
                        </div>

                        <div class="col-42">
                            <div class="text right-column">
                                <p>{{ setting('company.name') }}</p>

                                @if (company()->location)
                                    <p>
                                        {!! nl2br(setting('company.address')) !!}
                                        {!! company()->location !!}
                                    </p>
                                @endif

                                @if (setting('company.tax_number'))
                                    <p>
                                        <span class="text-medium">
                                            {{ trans('general.tax_number') }}:
                                        </span>
                                        {{ setting('company.tax_number') }}
                                    </p>
                                @endif

                                @if (setting('company.phone'))
                                    <p>
                                        {{ setting('company.phone') }}
                                    </p>
                                @endif

                                <p class="small-text">{{ setting('company.email') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row top-spacing">
                        <div class="col-50">
                            <div class="text">
                                {{-- <p class="text-semibold">{{ trans('payroll::general.employee_profile_information') }}</p> --}}

                                <p class="mb-0">
                                    <span class="text-semibold spacing">{{ trans_choice('payroll::general.employees', 1) }}:</span>
                                    <span class="float-right spacing mr-5" id="employee-name" v-html="pay_slips.employee.name">-</span>
                                </p>

                                <p class="mb-0">
                                    <span class="text-semibold spacing">{{ trans_choice('employees::general.departments', 1) }}:</span>
                                    <span class="float-right spacing mr-5" id="employee-department" v-html="pay_slips.employee.department">-</span>
                                </p>

                                <p class="mb-0">
                                    <span class="text-semibold spacing">{{ trans('general.tax_number') }}:</span>
                                    <span class="float-right spacing mr-5" id="employee-tax-number" v-html="pay_slips.employee.tax_number">-</span>
                                </p>

                                <p class="mb-0">
                                    <span class="text-semibold spacing">{{ trans('employees::employees.bank_account_number') }}:</span>
                                    <span class="float-right spacing mr-5" id="employee-bank-account" v-html="pay_slips.employee.bank_account_number">-</span>
                                </p>
                            </div>
                        </div>

                        <div class="col-50">
                            <div class="text">
                                <p class="mb-0">
                                    <span class="text-semibold spacing ml-5">{{ trans_choice('general.payment_methods', 1) }}:</span>
                                    <span class="float-right spacing" id="employee-payment-methods" v-html="pay_slips.employee.payment_method">-</span>
                                </p>

                                <p class="mb-0">
                                    <span class="text-semibold spacing ml-5">{{ trans('payroll::run-payrolls.payment_date') }}:</span>
                                    <span class="float-right spacing" id="employee-payment-date" v-html="pay_slips.employee.payment_date">-</span>
                                </p>

                                <p class="mb-0">
                                    <span class="text-semibold spacing ml-5">{{ trans('payroll::run-payrolls.from_date') }}:</span>
                                    <span class="float-right spacing" id="employee-from-date" v-html="pay_slips.employee.from_date">-</span>
                                </p>

                                <p class="mb-0">
                                    <span class="text-semibold spacing ml-5">{{ trans('payroll::run-payrolls.to_date') }}:</span>
                                    <span class="float-right spacing" id="employee-to-date" v-html="pay_slips.employee.to_date">-</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-50">
                            <div class="text extra-spacing mr-6">
                                <table class="c-lines">
                                    <thead>
                                        <tr>
                                            <th class="text-left item text text-semibold pl-0">{{ trans_choice('payroll::general.benefits', 2) }}</th>

                                            <th class="total text text-semibold pr-0">{{ trans('general.amount') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody v-if="pay_slips.employee.salary">
                                        <tr>
                                            <td class="item text pl-0"> {{ trans_choice('payroll::general.salaries', 1) }} </td>
                                            <td class="total text pr-0" v-html="pay_slips.employee.salary">-</td>
                                        </tr>

                                        <tr v-for="benefit in pay_slips.employee.benefits">
                                            <td class="item text pl-0" v-html="benefit.name">-</td>
                                            <td class="total text pr-0" v-html="benefit.amount">-</td>
                                        </tr>
                                    </tbody>

                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5" class="text-center text empty-items">
                                                {{ trans('documents.empty_items') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-50">
                            <div class="text extra-spacing ml-6">
                                <table class="c-lines">
                                    <thead>
                                        <tr>
                                            <th class="text-left item text text-semibold pl-0">{{ trans_choice('payroll::general.deductions', 2) }}</th>

                                            <th class="total text text-semibold pr-0">{{ trans('general.amount') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody v-if="pay_slips.employee.deductions.length">
                                        <tr v-for="deduction in pay_slips.employee.deductions">
                                            <td class="item text pl-0" v-html="deduction.name">-</td>
                                            <td class="total text pr-0" v-html="deduction.amount">-</td>
                                        </tr>
                                    </tbody>

                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5" class="text-center text empty-items">
                                                {{ trans('documents.empty_items') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 clearfix">
                        <div class="col-70">
                            <div class="text">
                            </div>
                        </div>

                        <div class="col-30 float-right text-right">
                            <div class="text border-bottom-dashed py-1">
                                <span class="float-left text-semibold">{{ trans_choice('general.totals', 2) }}: </span>
                                <span v-html="pay_slips.employee.total">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <x-button
                type="submit"
                class="relative flex items-center content-end bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
                ::disabled="form.loading"
                override="class"
            >
                <i v-if="form.loading" class="submit-spin absolute w-3 h-3 rounded-full left-0 right-0 -top-3.5 m-auto"></i>
                <span :class="[{'opacity-0': form.loading}]">
                    {{ trans('payroll::general.next') }}
                </span>
            </x-button>
        </div>
    </x-form>
</x-form.container>

<component v-bind:is="dynamic_component"></component>

