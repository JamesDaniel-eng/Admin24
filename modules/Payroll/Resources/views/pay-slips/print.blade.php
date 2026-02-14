<x-layouts.print>
    <x-slot name="title">
        {{ trans_choice('payroll::general.pay_slips', 1) . ': ' . $pay_slip->run_payroll->name }}
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-col lg:flex-row mt-4 print-template">
            <div class="lg:w-full lg:pl-12">
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
                                <p class="mb-0 mr-2">
                                    <span class="text-semibold spacing">
                                        {{ trans_choice('payroll::general.employees', 1) . ': ' }}
                                    </span>
                                    <span class="float-right spacing mr-5">
                                        {{ $pay_slip->employee->name }}
                                    </span>
                                </p>

                                <p class="mb-0">
                                    <span class="text-semibold spacing">
                                        {{ trans_choice('employees::general.departments', 1) . ': ' }}
                                    </span>
                                    <span class="float-right spacing mr-5">
                                        {{ $pay_slip->employee->department->name }}
                                    </span>
                                </p>

                                <p class="mb-0">
                                    <span class="text-semibold spacing">
                                        {{ trans('general.tax_number'). ': ' }}
                                    </span>
                                    <span class="float-right spacing mr-5">
                                        {{ $data['tax_number'] }}
                                    </span>
                                </p>

                                <p class="mb-0">
                                    <span class="text-semibold spacing">
                                        {{ trans('employees::employees.bank_account_number') . ': ' }}
                                    </span>
                                    <span class="float-right spacing mr-5">
                                        {{ $data['bank_account_number'] }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="col-50">
                            <div class="text">
                                <p class="mb-0 pl-3">
                                    <span class="text-semibold spacing ml-5">
                                        {{ trans_choice('general.payment_methods', 1) . ': ' }}
                                    </span>
                                    <span class="float-right spacing">
                                        {{ $data['payment_method'] }}
                                    </span>
                                </p>

                                <p class="mb-0 pl-3">
                                    <span class="text-semibold spacing ml-5">
                                        {{ trans('payroll::run-payrolls.payment_date') . ': ' }}
                                    </span>
                                    <span class="float-right spacing">
                                        {{ $data['payment_date'] }}
                                    </span>
                                </p>

                                <p class="mb-0 pl-3">
                                    <span class="text-semibold spacing ml-5">
                                        {{ trans('payroll::run-payrolls.from_date') . ': ' }}
                                    </span>
                                    <span class="float-right spacing">
                                        {{ $data['from_date'] }}
                                    </span>
                                </p>

                                <p class="mb-0 pl-3">
                                    <span class="text-semibold spacing ml-5">
                                        {{ trans('payroll::run-payrolls.to_date') . ': ' }}
                                    </span>
                                    <span class="float-right spacing">
                                        {{ $data['to_date'] }}
                                    </span>
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
                                            <th colspan="5" class="text-left item text text-semibold pl-0">
                                                {{ trans_choice('payroll::general.benefits', 2) }}
                                            </th>
                                            <th colspan="5" class="total text text-semibold pr-0">
                                                {{ trans('general.amount') }}
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="item text pl-0">
                                                {{ trans_choice('payroll::general.salaries', 1) }}
                                            </td>
                                            <td colspan="5" class="total text pr-0">
                                                <x-money :amount="$data['salary']" :currency="$pay_slip->run_payroll->currency_code" convert />
                                            </td>
                                        </tr>
                                        @if (! empty($data['benefits']))
                                            @foreach ($data['benefits'] as $benefit)
                                                <tr>
                                                    <td colspan="5" class="item text pl-0">
                                                        {{ $benefit['name'] }}
                                                    </td>
                                                    <td colspan="5" class="total text pr-0">
                                                        <x-money :amount="$benefit['amount']" :currency="$pay_slip->run_payroll->currency_code" convert />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-50">
                            <div class="text extra-spacing right-column ml-6 pl-3">
                                <table class="c-lines">
                                    <thead>
                                        <tr>
                                            <th colspan="5" class="text-left item text text-semibold pl-0">
                                                {{ trans_choice('payroll::general.deductions', 2) }}
                                            </th>
                                            <th colspan="5" class="total text text-semibold pr-0">
                                                {{ trans('general.amount') }}
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if (! empty($data['deductions']))
                                            @foreach ($data['deductions'] as $deduction)
                                                <tr>
                                                    <td colspan="5" class="item text pl-0">
                                                        {{ $deduction['name'] }}
                                                    </td>
                                                    <td colspan="5" class="total text pr-0">
                                                        <x-money :amount="$deduction['amount']" :currency="$pay_slip->run_payroll->currency_code" convert />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="align-items-center">
                                                    {{ trans('documents.empty_items') }}
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-8 top-spacing">
                        <div class="col-50">
                            <div class="text">
                            </div>
                        </div>

                        <div class="col-50">
                            <div class="text">
                                <p class="mb-0 pl-3">
                                    <span class="text-semibold spacing ml-5">
                                        {{ trans_choice('general.totals', 2) . ': ' }}
                                    </span>
                                    <span class="float-right spacing">
                                        <x-money :amount="$data['total']" :currency="$pay_slip->run_payroll->currency_code" convert />
                                        </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-layouts.print>