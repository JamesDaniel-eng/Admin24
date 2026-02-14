<x-layouts.print>
    <x-slot name="title">
        {{ trans_choice('payroll::general.pay_slips', 1) }}
    </x-slot>

    <x-slot name="content">   
        <div class="w-full lg:w-8/12 lg:pl-12 print-template">
            <div class="print-content p-7 shadow-2xl rounded-2xl">
                <div class="row">
                    <div class="col-100">
                        <div class="text text-dark">
                            <h3>
                                {{ trans('payroll::general.name') }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-58">
                        <div class="text">
                            <img src="{{ $data['logo'] }}" height="70" width="70" alt="{{ setting('company.name') }}" />
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

                            <p class="pb-0">
                                <span class="text-semibold spacing">{{ trans_choice('payroll::general.employees', 1) }} :</span>
                                <span class="float-right spacing" id="employee-name">{{ $data['name'] }}</span>
                            </p>

                            <p class="pb-0">
                                <span class="text-semibold spacing">{{ trans_choice('employees::general.departments', 1) }} :</span>
                                <span class="float-right spacing" id="employee-department">{{ $data['department'] }}</span>
                            </p>

                            <p class="pb-0">
                                <span class="text-semibold spacing">{{ trans('general.tax_number') }} :</span>
                                <span class="float-right spacing" id="employee-tax-number">{{ $data['tax_number'] }}</span>
                            </p>

                            <p class="pb-0">
                                <span class="text-semibold spacing">{{ trans('employees::employees.bank_account_number') }} :</span>
                                <span class="float-right spacing" id="employee-bank-account">{{ $data['bank_account_number'] }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="col-50">
                        <div class="text">
                            <p class="pb-0">
                                <span class="text-semibold spacing pl-5">{{ trans_choice('general.payment_methods', 1) }} :</span>
                                <span class="float-right spacing" id="employee-payment-methods">{{ $data['payment_method'] }}</span>
                            </p>

                            <p class="pb-0">
                                <span class="text-semibold spacing pl-5">{{ trans('payroll::run-payrolls.payment_date') }} :</span>
                                <span class="float-right spacing" id="employee-payment-date">{{ $data['payment_date'] }}</span>
                            </p>

                            <p class="pb-0">
                                <span class="text-semibold spacing pl-5">{{ trans('payroll::run-payrolls.from_date') }} :</span>
                                <span class="float-right spacing" id="employee-from-date">{{ $data['from_date'] }}</span>
                            </p>

                            <p class="pb-0">
                                <span class="text-semibold spacing pl-5">{{ trans('payroll::run-payrolls.to_date') }} :</span>
                                <span class="float-right spacing" id="employee-to-date">{{ $data['to_date'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-50">
                        <div class="text extra-spacing">
                            <table class="c-lines">
                                <thead>
                                    <tr>
                                        <th class="text-left item text text-semibold pl-0">{{ trans_choice('payroll::general.benefits', 2) }}</th>

                                        <th class="total text text-semibold pr-0">{{ trans('general.amount') }}</th>
                                    </tr>
                                </thead>

                                @if ($data['salary'])
                                    <tbody>
                                        <tr>
                                            <td class="item text pl-0"> {{ trans_choice('payroll::general.salaries', 1) }} </td>
                                            <td class="total text pr-0">{{ $data['salary'] }}</td>
                                        </tr>

                                        @foreach($data['benefits'] as $benefit)
                                            <tr>
                                                <td class="text-left item text pl-0">{{ $benefit['name'] }}</td>
                                                <td class="total text pr-0">{{ $benefit['amount'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center text empty-items">
                                                {{ trans('documents.empty_items') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>

                    <div class="col-50">
                        <div class="text extra-spacing right-column pl-5">
                            <table class="c-lines">
                                <thead>
                                    <tr>
                                        <th class="text-left item text text-semibold pl-0">{{ trans_choice('payroll::general.deductions', 2) }}</th>

                                        <th class="total text text-semibold pr-0">{{ trans('general.amount') }}</th>
                                    </tr>
                                </thead>

                                @if ($data['deductions'])
                                    <tbody>
                                        @foreach($data['deductions'] as $deduction)
                                            <tr>
                                                <td class="text-left item text pl-0">{{ $deduction['name'] }}</td>
                                                <td class="total text pr-0">{{ $deduction['amount'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center text empty-items">
                                                {{ trans('documents.empty_items') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                @endif
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
                            <span class="float-left text-semibold">{{ trans_choice('general.totals', 2) . ' : '}}</span>
                            <span>{{ $data['total'] }}</span>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </x-slot>
</x-layout-print>