<x-form id="edit_payitem_form" method="PATCH" :route="['payroll.settings.pay-item.update', $pay_item->id]" :model="$pay_item">
    <x-form.section>
        <x-slot name="body">
            <x-form.group.select name="pay_type" label="{{ trans('payroll::settings.pay_type') }}" :options="$pay_types" :selected="$pay_item->pay_type" />

            <x-form.group.text name="pay_item" label="{{ trans('payroll::settings.pay_item') }}" />

            <x-form.group.select name="amount_type" label="{{ trans('payroll::settings.amount_type') }}" :options="$amount_types" :selected="$pay_item->amount_type" />
        </x-slot>
    </x-form.section>
</x-form>
