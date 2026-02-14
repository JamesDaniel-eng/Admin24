<x-form id="new_benefit_form" :route="['payroll.modals.employees.benefit.store', $employee->id]">
    <x-form.section>
        <x-slot name="body">
            <x-form.group.select name="type" label="{{ trans_choice('general.types', 1) }}" :options="$type" form-group-class="sm:col-span-6" />

            <x-form.group.money name="amount" label="{{ trans('general.amount') }}" value="0" autofocus="autofocus" :currency="$currency" form-group-class="sm:col-span-6" convert />

            <x-form.group.select name="recurring" label="{{ trans('payroll::general.recurring') }}" :options="$recurring" form-group-class="sm:col-span-6" change="toggleToDateFieldBenefit" />

            <x-form.group.textarea name="description" label="{{ trans('general.description') }}" form-group-class="sm:col-span-6" not-required />
        
            <x-form.input.hidden name="employee_id" value="{{ $employee->id }}" />
        </x-slot>
    </x-form.section>
</x-form>

