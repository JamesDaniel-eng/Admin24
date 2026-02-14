@extends('layouts.admin')

@section('title', trans_choice('payroll::general.run_payrolls', 2))

@section('content')
    <div class="card">
        <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">

            <div class="row invoice-header">
                <div class="col-xs-5 invoice-company">
                    <strong>{{ $run_payrolls[0]->run_payroll->name}}</strong>
                </div>
                <div class="col-xs-7 text-right">
                    <strong> {{ trans('payroll::run-payrolls.payment_date') }} : </strong> 
                    <x-date date="{{ $run_payrolls[0]->run_payroll->payment_date }}" />
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-flush table-hover">
                <thead class="thead-light">
                    <tr class="row table-head-line">
                        <th class="col-md-4">@sortablelink('name', trans('general.name'))</th>
                        <th class="col-md-2 hidden-xs">{{ trans_choice('payroll::general.benefits', 1) }}</th>
                        <th class="col-md-2 hidden-xs">{{ trans_choice('payroll::general.deductions', 1) }}</th>
                        <th class="col-md-2 hidden-xs">{{ trans_choice('payroll::general.salaries', 1) }}</th>
                        <th class="col-md-2 hidden-xs">{{ trans_choice('general.totals', 1) }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($run_payrolls as $payroll)
                        <tr class="row align-items-center border-top-1">
                            <td class="col-md-4 border-0">{{ $payroll->employee->name }}</td>
                            <td class="col-md-2 border-0">
                                <x-money :amount="$payroll->benefit" :currency="$payroll->run_payroll->currency_code" convert />
                            </td>
                            <td class="col-md-2 border-0">
                                <x-money :amount="$payroll->deduction" :currency="$payroll->run_payroll->currency_code" convert />
                            </td>
                            <td class="col-md-2 border-0">
                                <x-money :amount="$payroll->salary" :currency="$payroll->run_payroll->currency_code" convert />
                            </td>
                            <td class="col-md-2 border-0">
                                <x-money :amount="$payroll->total" :currency="$payroll->run_payroll->currency_code" convert />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
