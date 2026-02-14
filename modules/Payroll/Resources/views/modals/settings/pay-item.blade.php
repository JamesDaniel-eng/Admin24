<x-form id="add_payitem_form" route="payroll.settings.pay-item.store">
    <x-form.section>
        <x-slot name="body">
            <x-form.group.select name="pay_type" label="{{ trans('payroll::settings.pay_type') }}" :options="$pay_types" />

            <x-form.group.text name="pay_item" label="{{ trans('payroll::settings.pay_item') }}" />

            <x-form.group.select name="amount_type" label="{{ trans('payroll::settings.amount_type') }}" :options="$amount_types" />
        </x-slot>
    </x-form.section>
</x-form>
