<x-form.container class="relative lg:w-full z-10" override="class">
    <x-form id="run-payroll" :route="['payroll.run-payrolls.employees.update', $run_payroll->id]">
        <x-form.section>
            <x-slot name="body">
                <x-form.group.date 
                    name="from_date" 
                    label="{{ trans('payroll::run-payrolls.from_date') }}" 
                    icon="calendar_today" 
                    value="{{ $run_payroll->from_date }}" 
                    show-date-format="{{ company_date_format() }}" 
                    date-format="Y-m-d" 
                    autocomplete="off"
                    change="setToDate" 
                    form-group-class="sm:col-span-2" 
                />

                <x-form.group.date 
                    name="to_date" 
                    label="{{ trans('payroll::run-payrolls.to_date') }}" 
                    icon="calendar_today" 
                    value="{{ $run_payroll->to_date }}" 
                    show-date-format="{{ company_date_format() }}" 
                    date-format="Y-m-d" 
                    autocomplete="off"
                    period="0"
                    min-date="form.from_date"
                    min-date-dynamic="min_to_date"
                    data-value-min
                    max-date="max_to_date"
                    max-date-dynamic="max_to_date"
                    form-group-class="sm:col-span-2" 
                />

                <x-form.group.date 
                    name="payment_date" 
                    label="{{ trans('payroll::run-payrolls.payment_date') }}" 
                    icon="calendar_today" 
                    value="{{ $run_payroll->payment_date }}" 
                    show-date-format="{{ company_date_format() }}" 
                    date-format="Y-m-d" 
                    autocomplete="off" 
                    period="0"
                    min-date="form.from_date"
                    min-date-dynamic="min_to_date"
                    data-value-min
                    form-group-class="sm:col-span-2" 
                />
            </x-slot>
        </x-form.section>

        <div class="border-b-2 border-gray-200 mb-10 pb-4" x-data="{create:null}">
            <button type="button" class="relative w-full text-left cursor-pointer" x-on:click="create !== 1 ? create = 1 : create = null">
                <span class="font-medium">{{ trans('payroll::general.advanced') }}</span>
                <span class="material-icons absolute right-0 top-0 transition-all transform" x-bind:class="create === 1 ? 'rotate-180' : ''">expand_more</span>
            </button>

            <div class="relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="create == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                <div class="grid sm:grid-cols-6 gap-x-8 gap-y-6 my-3.5">
                    <x-form.group.text name="name" label="{{ trans('general.name') }}" :value="old('name', $run_payroll->name)" />

                    <x-form.group.category type="expense" :selected="$run_payroll->category_id" />

                    <x-form.group.account :selected="$run_payroll->account_id" />
    
                    <x-form.group.payment-method :selected="$run_payroll->payment_method" />
                    
                    <x-form.input.hidden name="pay_calendar_id" value="{{ $run_payroll->pay_calendar->id }}" />
                    <x-form.input.hidden name="pay_calendar_type" value="{{ $run_payroll->pay_calendar->type }}" />
                    <x-form.input.hidden name="run_payroll_id" value="{{ $run_payroll->id }}" />
                </div>
            </div>
        </div>

        <x-table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th class="w-4/12">
                        <x-slot name="first">
                            {{ trans('general.name') }}
                        </x-slot>
                        <x-slot name="second">
                            {{ trans_choice('employees::general.departments', 1) }}
                        </x-slot>
                    </x-table.th>

                    <x-table.th class="w-4/12 sm:w-2/12">
                        <x-slot name="first">
                            {{ trans_choice('payroll::general.salaries', 1) }}
                        </x-slot>
                        <x-slot name="second">
                            {{ trans_choice('general.types', 1) }}
                        </x-slot>
                    </x-table.th>

                    <x-table.th class="w-2/12" kind="amount" hidden-mobile>
                        {{ trans_choice('payroll::general.benefits', 1) }}
                    </x-table.th>

                    <x-table.th class="w-2/12" kind="amount" hidden-mobile>
                        {{ trans_choice('payroll::general.deductions', 1) }}
                    </x-table.th>

                    <x-table.th class="w-4/12 sm:w-2/12" kind="amount">
                        {{ trans('payroll::general.total', ['type' => trans('general.amount')]) }}
                    </x-table.th>
                </x-table.tr>
            </x-table.thead>

            <x-table.tbody>
                @foreach($employees as $item)
                    <x-table.tr href="{{ route('employees.employees.show', $item->employee->id ) }}">
                        <x-table.td class="w-4/12">
                            <x-slot name="first" class="flex font-bold" override="class">
                                {{ !empty($item->employee->contact) ? $item->employee->contact->name : '-' }}
                            </x-slot>
                            <x-slot name="second" class="font-normal" override="class">
                                {{ $item->employee->department->name }}
                            </x-slot>
                        </x-table.td>

                        <x-table.td class="w-4/12 sm:w-2/12">
                            <x-slot name="first" class="flex font-bold" override="class">
                                <x-money :amount="$item->salary" :currency="$item->employee->contact->currency_code" convert />
                            </x-slot>
                            <x-slot name="second" class="font-normal" override="class">
                                {{ trans('employees::employees.salary_types.' . ($item->employee->salary_type ?? 'monthly')) }}
                            </x-slot>
                        </x-table.td>

                        <x-table.td class="w-2/12" kind="amount" hidden-mobile>
                            <x-money :amount="$item->benefit" :currency="$item->employee->contact->currency_code" convert />
                        </x-table.td>

                        <x-table.td class="w-2/12" kind="amount" hidden-mobile>
                            <x-money :amount="$item->deduction" :currency="$item->employee->contact->currency_code" convert />
                        </x-table.td>

                        <x-table.td class="w-4/12 sm:w-2/12" kind="amount">
                            <x-money :amount="$item->total" :currency="$item->employee->contact->currency_code" convert />
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table>

        <x-form.section>
            <x-slot name="foot">
                <div class="flex justify-end mt-4">
                    <x-button
                        type="submit"
                        class="relative bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
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
