<x-index.container>
    <x-form id="setting" method="POST" route="employees.settings.update">
        <x-form.section>
            <x-slot name="head">
                <x-form.section.head title="{{ trans('general.general') }}" description="{{ trans('employees::employees.form_description.setting_general') }}" />
            </x-slot>

            <x-slot name="body">
                <x-form.group.select name="default_role_id" label="{{ trans('employees::general.default_role') }}" :options="$roles" :selected="old('default_role_id', setting('employees.default_role_id'))" />

                <x-form.group.select name="default_salary_type" label="{{ trans('employees::general.salary_type') }}" :options="trans('employees::employees.salary_types')" :selected="old('default_salary_type', setting('employees.default_salary_type', 'monthly'))" />
            </x-slot>
        </x-form.section>

        <x-form.section>
            <x-slot name="head">
                <x-form.section.head title="{{ trans_choice('employees::general.dismissals', 1) }}" description="{{ trans('employees::employees.form_description.setting_dismissal') }}" />
            </x-slot>

            <x-slot name="body">
                <div class="sm:col-span-6 overflow-x-scroll large-overflow-unset">
                    <div class="small-table-width">
                        <x-table class="flex flex-col divide-y divide-gray-200">
                            <x-table.thead>
                                <x-table.tr>
                                    <x-table.th class="w-full ml-3">
                                        {{ trans('employees::general.dismissal_type') }}
                                    </x-table.th>
                                </x-table.tr>
                            </x-table.thead>
                    
                            <x-table.tbody>
                                <x-table.tr class="relative flex items-center px-1 group/actions border-b" v-for="(row, index) in form.items" ::index="index">
                                    <x-table.td class="w-11/12">
                                        <x-form.group.text name="items[][dismissal_type]" value="" data-item="dismissal_type" v-model="row.dismissal_type" />
                                    </x-table.td>
                    
                                    <x-table.td class="w-1/12 none-truncate" override="class">
                                        <x-button type="button" @click="onDeleteDismissal(index)" class="px-3 py-1.5 mb-3 sm:mt-2 sm:mb-0 rounded-xl text-sm font-medium leading-6 hover:bg-gray-200 disabled:bg-gray-50" override="class">
                                            <span class="w-full material-icons-outlined text-lg text-gray-300 group-hover:text-gray-500">delete</span>
                                        </x-button>
                                    </x-table.td>
                                </x-table.tr>
                                <x-table.tr id="addItem">
                                    <x-table.td class="w-full">
                                        <x-button type="button" override="class" @click="onAddDismissal" class="w-full text-secondary flex items-center justify-center" title="{{ trans('general.add') }}">
                                            <span class="material-icons-outlined text-base font-bold mr-1">add</span>
                                            {{ trans('general.form.add', ['field' => trans('employees::general.dismissal_type')]) }}
                                        </x-button>
                                    </x-table.td>
                                </x-table.tr>
                            </x-table.tbody>
                        </x-table>
                    </div>
                </div>
            </x-slot>
        </x-form.section>

        <x-form.section>
            <x-slot name="foot">
                <x-form.buttons :cancel="url()->previous()" />
            </x-slot>
        </x-form.section>
    </x-form>
</x-index.container>
