<x-table>
    <x-table.thead>
        <x-table.tr class="flex items-center px-1" override="class">
            <x-table.th class="w-full ml-5">
                {{ trans('payroll::settings.pay_item') }}
            </x-table.th>
        </x-table.tr>
    </x-table.thead>

    <x-table.tbody>
        <x-table.tr class="relative flex items-center px-1 group/actions border-b" v-for="(row, index) in form.deductions" ::index="index">
            <x-table.td class="w-10/12 ml-5">
                <x-form.group.text name="deductions[][pay_item]" value="" data-item="pay_item" v-model="row.pay_item" />
            </x-table.td>

            <x-table.td class="w-2/12 none-truncate" override="class">
                <x-button type="button" @click="onDeleteDeduction(index)" class="px-3 py-1.5 mb-3 sm:mt-2 sm:mb-0 rounded-xl text-sm font-medium leading-6 hover:bg-gray-200 disabled:bg-gray-50" override="class">
                    <span class="w-full material-icons-outlined text-lg text-gray-300 group-hover:text-gray-500">delete</span>
                </x-button>
            </x-table.td>
        </x-table.tr>
        <x-table.tr id="addItem">
            <x-table.td class="w-full">
                <x-button type="button" override="class" @click="onAddDeduction" class="w-full text-secondary flex items-center justify-center" title="{{ trans('general.add') }}">
                    <span class="material-icons-outlined text-base font-bold mr-1">add</span>
                    {{ trans('general.form.add', ['field' => trans('payroll::settings.pay_item')]) }}
                </x-button>
            </x-table.td>
        </x-table.tr>
    </x-table.tbody>
</x-table>

