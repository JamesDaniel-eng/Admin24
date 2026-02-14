<x-form.container class="relative lg:w-full z-10" override="class">
    <x-form id="run-payroll" :route="['payroll.run-payrolls.variables.update', $run_payroll->id]">
        <div class="flex flex-col lg:flex-row lg:space-x-24 rtl:space-x-reverse space-y-12 lg:space-y-0">
            <div class="lg:w-4/12 space-y-12">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('payroll::general.employee_profile_information') }}" description="{{ trans('payroll::run-payrolls.form_description.employee_profile_information') }}" />
                    </x-slot>
        
                    <x-slot name="body">
                        <akaunting-select
                            class="sm:col-span-6"
                            :title="'{{ trans_choice('payroll::general.employees', 1) }}'"
                            :placeholder="'{{ trans('general.form.select.field', ['field' => trans_choice('payroll::general.employees', 1)]) }}'"
                            :name="'employee'"
                            :options="{{ json_encode($employees) }}"
                            :value="'{{ old('employee') }}'"
                            @interface="form.employee = $event"
                            @change="onChangeEmployee"
                        ></akaunting-select>
        
                        <x-form.input.hidden name="paycalendar_id" value="{{ $run_payroll->pay_calendar->id }}" />
        
                        <x-form.input.hidden name="run_payroll_id" value="{{ $run_payroll->id }}" />
                         
                        <dl class="sm:col-span-6 border-b border-gray-200 divide-y divide-gray-200">
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">
                                    {{ trans_choice('payroll::general.salaries', 1) }}
                                </dt>
            
                                <dd class="text-gray-900" v-if="variables.employee.salary==false">
                                    <x-money :amount="0" :currency="$run_payroll->currency_code" convert />
                                </dd>
            
                                <dd class="text-gray-900" v-else v-html="variables.employee.salary"></dd>
                            </div>
            
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">
                                    {{ trans_choice('payroll::general.benefits', 1) }}
                                </dt>
            
                                <dd class="text-gray-900" v-if="variables.employee.benefits==false">
                                    <x-money :amount="0" :currency="$run_payroll->currency_code" convert />
                                </dd>
            
                                <dd class="text-gray-900" v-else v-html="variables.employee.benefits"></dd>
                            </div>
            
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">
                                    {{ trans_choice('payroll::general.deductions', 1) }}
                                </dt>
            
                                <dd class="text-gray-900" v-if="variables.employee.deductions==false">
                                    <x-money :amount="0" :currency="$run_payroll->currency_code" convert />
                                </dd>
            
                                <dd class="text-gray-900" v-else v-html="variables.employee.deductions"></dd>
                            </div>
            
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">
                                    {{ trans('payroll::general.total', ['type' => trans('general.amount')]) }}
                                </dt>
            
                                <dd class="text-gray-900" v-if="variables.employee.total==false">
                                    <x-money :amount="0" :currency="$run_payroll->currency_code" convert />
                                </dd>
            
                                <dd class="text-gray-900" v-else v-html="variables.employee.total"></dd>
                            </div>
                        </dl>
                    </x-slot>
                </x-form.section>
            </div>
        
            <div class="lg:w-8/12">
                <x-form.section.head title="{{ trans_choice('payroll::general.benefits', 2) }}" description="{{ trans('payroll::run-payrolls.form_description.benefits') }}" />

                <x-table id="benefits">
                    <x-table.thead>
                        <x-table.tr>
                            @stack('benefit_type_th_start')
                                <x-table.th class="w-5/12">
                                    {{ trans_choice('general.types', 1) }}
                                </x-table.th>
                            @stack('benefit_type_th_end')

                            @stack('benefit_total_th_start')
                                <x-table.th class="w-5/12">
                                    {{ trans('general.amount') }}
                                </x-table.th>
                            @stack('benefit_total_th_end')

                            @stack('benefit_actions_th_start')
                                <x-table.th class="w-2/12 text-center">
                                    {{ trans('general.actions') }}
                                </x-table.th>
                            @stack('benefit_actions_th_end')
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @include('payroll::partials.employee.benefit.item')

                        <x-table.tr id="addBenefit">
                            <x-table.td class="w-full">
                                @stack('add_benefit_start')
                                    <button type="button"
                                        @click="addBenefit"
                                        :disabled="!this.form.employee"
                                        id="button-add-benefit-item"
                                        data-toggle="tooltip"
                                        title="{{ trans('general.add') }}"
                                        data-original-title="{{ trans('general.add') }}"
                                        class="w-full h-12 text-secondary">
                                        {{ trans('general.form.add', ['field' => trans_choice('payroll::general.benefits', 1)]) }}
                                    </button>
                                @stack('add_benefit_end')
                            </x-table.td>
                        </x-table.tr>
                    </x-table.tbody>
                </x-table>

                <x-form.section.head title="{{ trans_choice('payroll::general.deductions', 2) }}" description="{{ trans('payroll::run-payrolls.form_description.deductions') }}" />

                <x-table>
                    <x-table.thead>
                        <x-table.tr>
                            @stack('deduction_type_th_start')
                                <x-table.th class="w-5/12">
                                    {{ trans_choice('general.types', 1) }}
                                </x-table.th>
                            @stack('deduction_type_th_end')

                            @stack('deduction_total_th_start')
                                <x-table.th class="w-5/12">
                                    {{ trans('general.amount') }}
                                </x-table.th>
                            @stack('deduction_total_th_end')

                            @stack('deduction_actions_th_start')
                                <x-table.th class="w-2/12 text-center">
                                    {{ trans('general.actions') }}
                                </x-table.th>
                            @stack('deduction_actions_th_end')
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @include('payroll::partials.employee.deduction.item')

                        <x-table.tr id="addDeduction">
                            <x-table.td class="w-full">
                                @stack('add_deduction_start')
                                    <button type="button"
                                        @click="addDeduction"
                                        :disabled="!this.form.employee"
                                        id="button-add-deduction-item"
                                        data-toggle="tooltip"
                                        title="{{ trans('general.add') }}"
                                        data-original-title="{{ trans('general.add') }}"
                                        class="w-full h-12 text-secondary">
                                        {{ trans('general.form.add', ['field' => trans_choice('payroll::general.deductions', 1)]) }}
                                    </button>
                                @stack('add_deduction_end')
                            </x-table.td>
                        </x-table.tr>
                    </x-table.tbody>
                </x-table>
            </div>
        </div>

        <x-form.section>
            <x-slot name="foot">
                <div class="flex justify-end mt-4">
                    <x-button
                        type="submit"
                        class="relative flex items-center content-end bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
                        ::disabled="form.loading"
                        override="class"
                    >
                        <i v-if="form.loading" class="submit-spin absolute w-3 h-3 rounded-full left-0 right-0 -top-3.5 m-auto"></i>
                        <span :class="[{'opacity-0': form.loading}]">
                            {{ trans('payroll::general.next') }}
                        </span>
                    </x-button>
                </div>
            </x-slot>
        </x-form.section>
    </x-form>
</x-form.container>
