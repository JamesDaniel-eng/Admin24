<x-form id="form-create-dismissals" route="employees.modals.dismissals.store">
    <x-form.section>
        <x-slot name="body">
            <x-form.group.select name="type" label="{{ trans('employees::general.dismissal_type') }}" :options="$dismissal_types" :selected="reset($dismissal_types)" form-group-class="col-span-6" />

            <x-form.group.date 
                name="dismissal_date" 
                label="{{ trans('employees::general.dismissal_date') }}" 
                icon="calendar_today" 
                value="{{ request()->get('dismissal_date', Date::now()->toDateString()) }}" 
                show-date-format="{{ company_date_format() }}" 
                date-format="Y-m-d" 
                autocomplete="off"
                form-group-class="col-span-6"
            />

            <x-form.group.textarea name="reason" label="{{ trans('employees::general.reason') }}" not-required />

            {{-- bulk action dismissals --}}
            @if (isset($selected))
                <x-form.input.hidden name="selected_employee_ids" :value="implode(',', $selected)" />
            @else
                <x-form.input.hidden name="employee_id" :value="$employee_id ?? null" />
            @endif
        </x-slot>
    </x-form.section>
</x-form>
