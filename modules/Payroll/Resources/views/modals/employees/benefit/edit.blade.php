<x-form id="edit_benefit_form" method="PATCH" :route="['payroll.modals.payroll.employee.benefit.modal.update', ['company_id' => company_id(), 'benefit' => $benefit->id]]" :model="$benefit">
    <x-form.section>
        <x-slot name="body">
            <x-form.group.select name="type" label="{{ trans_choice('general.types', 1) }}" :options="$type" :selected="$benefit->type" form-group-class="sm:col-span-6" />

            <x-form.group.money name="amount" label="{{ trans('general.amount') }}" :value="$benefit->amount" autofocus="autofocus" :currency="$currency" form-group-class="sm:col-span-6" convert />

            <x-form.group.select name="recurring" label="{{ trans('payroll::general.recurring') }}" :options="$recurring" :selected="$benefit->recurring" form-group-class="sm:col-span-6" />

            <x-form.group.textarea name="description" label="{{ trans('general.description') }}" not-required />        
        </x-slot>
    </x-form.section>
</x-form>

