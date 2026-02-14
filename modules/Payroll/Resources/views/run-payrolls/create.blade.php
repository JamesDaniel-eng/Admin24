<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.new', ['type' => trans('payroll::general.wizard.run_payroll')]) }}</x-slot>

    <x-slot name="content">
        <payroll-run-payroll
            :first-path="'{{ route('payroll.pay-calendars.run-payrolls.employees.create', $pay_calendar->id) }}'"
            :pay-calendar-id="{{ $pay_calendar->id }}"
            :start-step="0"
            :steps="{{ json_encode($steps) }}">
        </payroll-run-payroll>
    </x-slot>

    @push('scripts_start')
        <link rel="stylesheet" href="{{ asset('public/css/print.css?v=' . version('short')) }}" type="text/css">
    @endpush

    <x-script alias="payroll" file="run-payrolls" />
</x-layouts.admin>
