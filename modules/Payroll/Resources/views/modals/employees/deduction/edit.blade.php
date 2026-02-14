<x-form id="new_deduction_form" method="PATCH" :route="['payroll.modals.payroll.employee.deduction.modal.update', ['company_id' => company_id(), 'deduction' => $deduction->id]]" :model="$deduction">
    <x-form.section>
        <x-slot name="body">
            <x-form.group.select name="type" label="{{ trans_choice('general.types', 1) }}" :options="$type" :selected="$deduction->type" form-group-class="sm:col-span-6" />

            <x-form.group.money name="amount" label="{{ trans('general.amount') }}" :value="$deduction->amount" autofocus="autofocus" :currency="$currency" form-group-class="sm:col-span-6" convert />

            <x-form.group.select name="recurring" label="{{ trans('payroll::general.recurring') }}" :options="$recurring" :selected="$deduction->recurring" form-group-class="sm:col-span-6" />

            <x-form.group.textarea name="description" label="{{ trans('general.description') }}" not-required />        
        </x-slot>
    </x-form.section>
</x-form>

