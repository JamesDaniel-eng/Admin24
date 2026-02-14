<el-popover
    popper-class="p-0 h-0"
    placement="bottom-left"
    width="950"
    trigger="click"
    v-if="row.item_id && this.item_default_composite_items[row.item_id] != undefined && this.item_default_composite_items[row.item_id].length > 0"
>
    <div class="bg-white rounded-lg shadow-lg p-4">
        <div id="composite-items-vue-entrypoint">
            <div class="composite-components" id="composite-items">
                <h6 class="text-sm font-medium text-gray-900 mb-3">{{ trans('composite-items::general.name') }}</h6>

                <div class="overflow-y-auto max-h-64">
                    <x-table>
                        <x-table.thead>
                            <x-table.tr class="flex items-center px-1">
                                <x-table.th class="{{ isset($inventory_enabled) && $inventory_enabled ? 'w-3/12' : 'w-6/12' }} hidden sm:table-cell">
                                    {{ trans_choice('general.items', 1) }}
                                </x-table.th>

                                @if(isset($inventory_enabled) && $inventory_enabled)
                                <x-table.th class="w-3/12 hidden text-center sm:table-cell">
                                    {{ trans_choice('inventory::general.warehouses', 1) }}
                                </x-table.th>
                                @endif

                                <x-table.th class="w-2/12 hidden text-center sm:table-cell">
                                    {{ trans('composite-items::general.quantity') }}
                                </x-table.th>

                                <x-table.th class="w-2/12 hidden text-center sm:table-cell">
                                    {{ trans('invoices.price') }}
                                </x-table.th>

                                <x-table.th class="w-1/12 hidden text-center sm:table-cell" kind="amount">
                                    {{ trans('general.amount') }}
                                </x-table.th>

                                <x-table.th class="w-1/12 hidden text-center sm:table-cell">
                                </x-table.th>
                            </x-table.tr>
                        </x-table.thead>

                        <x-table.tbody>
                            <x-table.tr class="relative flex items-center border-b hover:bg-gray-100 px-1 group" v-for="(comp_row, comp_index) in (form.items[index] && form.items[index].composite_items && form.items[index].composite_items[row.item_id] ? form.items[index].composite_items[row.item_id] : [])" ::index="comp_index">
                                <x-table.td class="{{ isset($inventory_enabled) && $inventory_enabled ? 'w-3/12' : 'w-6/12' }} hidden sm:table-cell">
                                    <akaunting-select
                                        class="w-full"
                                        :form-classes="[{'has-error': form.errors.get('composite_items.' + comp_index + '.item_id') }]"
                                        :placeholder="'{{ trans('general.form.select.field', ['field' => trans_choice('general.items', 1)]) }}'"
                                        :name="'composite_items.' + comp_index + '[item_id]'"
                                        :options="{{ $items }}"
                                        :model="comp_row.item_id"
                                        :selected="comp_row.item_id"
                                        @interface="comp_row.item_id = $event"
                                        :form-error="form.errors.get('composite_items.' + comp_index + '.item_id')"
                                        :no-data-text="'{{ trans('general.no_data') }}'"
                                        :no-matching-data-text="'{{ trans('general.no_matching_data') }}'"
                                    ></akaunting-select>
                                </x-table.td>

                                @if(isset($inventory_enabled) && $inventory_enabled)
                                <x-table.td class="w-3/12 hidden sm:table-cell">
                                    <akaunting-select
                                        class="w-full"
                                        :form-classes="[{'has-error': form.errors.get('composite_items.' + comp_index + '.warehouse_id') }]"
                                        :placeholder="'{{ trans('general.form.select.field', ['field' => trans_choice('inventory::general.warehouses', 1)]) }}'"
                                        :name="'composite_items.' + comp_index + '[warehouse_id]'"
                                        :options="{{ $warehouses }}"
                                        :model="comp_row.warehouse_id"
                                        :selected="comp_row.warehouse_id"
                                        @interface="comp_row.warehouse_id = $event"
                                        :form-error="form.errors.get('composite_items.' + comp_index + '.warehouse_id')"
                                        :no-data-text="'{{ trans('general.no_data') }}'"
                                        :no-matching-data-text="'{{ trans('general.no_matching_data') }}'"
                                    ></akaunting-select>
                                </x-table.td>
                                @endif

                                <x-table.td class="w-2/12 hidden sm:table-cell">
                                    <input
                                        class="w-full text-sm px-3 py-2.5 mt-1 rounded-lg border border-light-gray text-black placeholder-light-gray bg-white disabled:bg-gray-200 focus:outline-none focus:ring-transparent focus:border-purple composite-item-quantity-input"
                                        :name="'composite_items.' + comp_index  + '[quantity]'"
                                        v-model="comp_row.quantity"
                                        :data-item-id="row.item_id"
                                        :data-item-index="index"
                                        :data-composite-index="comp_index"
                                        data-field="quantity"
                                        type="number"
                                        step="any"
                                        autocomplete="off"
                                    >
                                </x-table.td>

                                <x-table.td class="w-2/12 hidden sm:table-cell">
                                    <input
                                        class="w-full text-sm px-3 py-2.5 mt-1 rounded-lg border border-light-gray text-black placeholder-light-gray bg-white disabled:bg-gray-200 focus:outline-none focus:ring-transparent focus:border-purple composite-item-price-input"
                                        :name="'composite_items.' + comp_index  + '[price]'"
                                        v-model="comp_row.price"
                                        :data-item-id="row.item_id"
                                        :data-item-index="index"
                                        :data-composite-index="comp_index"
                                        data-field="price"
                                        type="number"
                                        step="any"
                                        autocomplete="off"
                                    >
                                </x-table.td>

                                <x-table.td class="w-1/12 hidden sm:table-cell" kind="amount">
                                    <akaunting-money
                                        class="w-full"
                                        :form-classes="[{'has-error': form.errors.get('composite_items.' + comp_index + '.amount') }]"
                                        :placeholder="'{{ trans('general.form.select.field', ['field' => trans_choice('inventory::general.warehouses', 1)]) }}'"
                                        :name="'composite_items.' + comp_index + '[amount]'"
                                        :dynamic-currency="currency"
                                        :model="comp_row.amount"
                                        :value="comp_row.amount"
                                        :disabled="true"
                                        money-class="ltr:text-right rtl:text-left mt-0 disabled-money px-0"
                                        @interface="comp_row.amount = $event"
                                        :form-error="form.errors.get('composite_items.' + comp_index + '.amount')"
                                        :no-data-text="'{{ trans('general.no_data') }}'"
                                        :no-matching-data-text="'{{ trans('general.no_matching_data') }}'"
                                    ></akaunting-money>
                                </x-table.td>

                                <x-table.td class="w-1/12 hidden sm:table-cell none-truncate" override="class">
                                    <button
                                        type="button"
                                        class="w-6 h-7 flex items-center rounded-lg p-0 group-hover:bg-gray-100 ml-4"
                                        ::data-delete-item-id="row.item_id"
                                        ::date-delete-item-index="index"
                                        ::data-delete-index="comp_index"
                                    >
                                        <span class="w-full material-icons-outlined text-lg text-gray-300 group-hover:text-gray-500">delete</span>
                                    </button>
                                </x-table.td>
                            </x-table.tr>

                            <x-table.tr id="addItem">
                                <x-table.td class="w-full hidden sm:table-cell" colspan="{{ isset($inventory_enabled) && $inventory_enabled ? '5' : '4' }}">
                                    <x-button
                                        type="button"
                                        override="class"
                                        class="w-full text-secondary flex items-center justify-center add-composite-item-btn"
                                        title="{{ trans('general.add') }}"
                                        ::data-add-item-id="row.item_id"
                                        ::data-add-item-index="index"
                                    >
                                        <span class="material-icons-outlined text-base font-bold mr-1">add</span>
                                        {{ trans('general.form.add_an', ['field' => trans_choice('general.items', 1)]) }}
                                    </x-button>
                                </x-table.td>
                            </x-table.tr>
                        </x-table.tbody>
                    </x-table>
                </div>
            </div>
        </div>
    </div>

    <x-button
        type="button"
        class="relative absolute -top-2 flex items-center text-right border-0 p-0 pr-4 text-xs text-purple"
        slot="reference"
        override="class"
        v-if="row.item_id && this.item_default_composite_items[row.item_id] != undefined && this.item_default_composite_items[row.item_id].length > 0"
    >
        <span class="border-b border-transparent transition-all hover:border-purple">
            {{ trans('general.edit') . ' '. trans('composite-items::general.name') }}
        </span>
    </x-button>
</el-popover>
