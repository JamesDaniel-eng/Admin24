<x-table.tr v-for="(row, index) in deductions">
    <x-table.td class="w-5/12">
        @stack('type_input_start')
            <div v-if="row.id">
                @{{ row.name }}
            </div>
            <akaunting-select v-else
                class="sm:col-span-6"
                :placeholder="'{{ trans('general.form.select.field', ['field' => trans_choice('payroll::general.deductions', 1)]) }}'"
                :name="'benefit_type_' + index"
                :options="{{ json_encode($deduction_type) }}"
                :value="row.type"
                @interface="row.type = $event"
            ></akaunting-select>
        @stack('type_input_end')
    </x-table.td>

    <x-table.td class="w-5/12">
        @stack('amount_input_start')
            <div v-if="row.id">
                @{{ row.amount_format }}
            </div>
            <akaunting-money v-else
                col="text-right input-price"
                :name="'deduction_amount' + index"
                required
                v-model="row.amount"
                @interface="row.amount = $event"
                :error="form.errors.get('deduction_amount.' + index)"
                :currency="row.currency"
                :dynamic-currency="row.currency"
            ></akaunting-money>
            <input :name="'deduction_currency.' + index"
                data-item="currency"
                v-model="row.currency"
                type="hidden">
        @stack('amount_input_end')
    </x-table.td>

    <x-table.td class="w-2/12">
        @stack('actions_button_start')
            <button v-if="row.id"
                type="button"
                data-toggle="tooltip"
                title="{{ trans('general.delete') }}"
                @click="deleteDeduction(row.id)">
                <span class="material-icons-outlined ml-8 hover:text-text-dark">delete</span>
            </button>
            <button v-else
                type="button"
                data-toggle="tooltip"
                title="{{ trans('general.save') }}"
                @click="saveDeduction(row)">
                <span class="material-icons-outlined ml-8 hover:text-text-dark">done</span>
            </button>
        @stack('actions_button_end')
    </x-table.td>
</x-table.tr>
