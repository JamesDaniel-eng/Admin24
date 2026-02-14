<dl class="sm:col-span-6 border-b border-gray-200 divide-y divide-gray-200">
    <div class="py-3 flex justify-between text-sm font-medium">
        <dt class="text-gray-500">
            {{ trans('general.name') }}
        </dt>

        <dd class="text-gray-900">
            {{ $deduction->pay_item->pay_item }}
        </dd>
    </div>
        
    <div class="py-3 flex justify-between text-sm font-medium">
        <dt class="text-gray-500">
            {{ trans('recurring.recurring') }}
        </dt>

        <dd class="text-gray-900">
            {{ trans('payroll::deductions.deduction_recurring.' . $deduction->recurring) }}
        </dd>
    </div>

    <div class="py-3 flex justify-between text-sm font-medium">
        <dt class="text-gray-500">
            {{ trans('general.amount') }}
        </dt>

        <dd class="text-gray-900">
            <x-money :amount="$deduction->amount" :currency="setting('default.currency')" convert />
        </dd>
    </div>

    <div class="py-3 flex justify-between text-sm font-medium">
        <dt class="text-gray-500">
            {{ trans('general.description') }}
        </dt>

        <dd class="text-gray-900">
            {{ $deduction->description }}
        </dd>
    </div>
</dl>
