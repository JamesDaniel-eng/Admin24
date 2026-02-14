<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.edit', ['type' => trans_choice('payroll::general.pay_calendars', 1)]) }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="pay-calendar" method="PATCH" :route="['payroll.pay-calendars.update', $pay_calendar->id]" :model="$pay_calendar">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" description="{{ trans('payroll::pay-calendars.form_description.information') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="name" label="{{ trans('general.name') }}" />

                        <x-form.group.select name="type" label="{{ trans_choice('general.types', 1) }}" :options="$types" :selected="$pay_calendar->type" change="onChangeType" form-group-class="sm:col-span-3" />

                        @stack('pay_day_mode_input_start')
                            <akaunting-select
                                class="sm:col-span-3 required"
                                v-if="field.pay_day_mode != ''"
                                :form-classes="[{'has-error': form.errors.get('pay_day_mode') }]"
                                :title="'{{ trans('payroll::pay-calendars.pay_day_mode') }}'"
                                :placeholder="'{{ trans('general.form.select.field', ['field' => trans('payroll::pay-calendars.pay_day_mode')]) }}'"
                                :name="'pay_day_mode'"
                                :options="{{ json_encode($pay_day_modes) }}"
                                :dynamic-options="options.pay_day_modes"
                                :value="'{{ old('pay_day_mode', $pay_calendar->pay_day_mode) }}'"
                                @interface="form.pay_day_mode = $event"
                                @change="onChangePayDayMode($event)"
                                :form-error="form.errors.get('pay_day_mode')"
                                :no-data-text="'{{ trans('general.no_data') }}'"
                                :no-matching-data-text="'{{ trans('general.no_matching_data') }}'"
                                :sort-options="false"
                            ></akaunting-select>
                        @stack('pay_day_mode_input_end')
        
                        @stack('pay_day_input_start')
                            <x-form.group.number name="pay_day" label="{{ trans('payroll::pay-calendars.pay_day') }}" v-model="form.pay_day" v-show="field.pay_day == true" />
                        @stack('pay_day_input_end')
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans_choice('payroll::general.employees', 2) }}" description="{{ trans('payroll::pay-calendars.form_description.employees') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.checkbox
                            name="employees"
                            :options="$employees"
                            option-key="id"
                            option-value="name"
                            :checked="$pay_calendar->employees->pluck('employee_id')->toArray()"
                            checkbox-class="sm:col-span-2"
                            v-model="form.employees"
                            not-required
                        />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="payroll.pay-calendars.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    @push('scripts_start')
        <script type="text/javascript">
            var default_data = {
                type: '{{ $pay_calendar->type }}',
                pay_day: '{{ $pay_calendar->pay_day }}',
                pay_day_mode: '{{ $pay_calendar->pay_day_mode }}',
            };
        </script>
    @endpush

    <x-script alias="payroll" file="pay-calendars" />
</x-layouts.admin>
