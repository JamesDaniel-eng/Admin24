<div class="flex justify-end mb-10">
    <x-button
        type="button"
        class="relative bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
        id="add-company"
        override="class"
        @click="onPayitem('{{ trans('payroll::settings.pay_item') }}')"
    >
        <span>
            {{ trans('general.title.new', ['type' => trans('payroll::settings.pay_item')]) }}
        </span>
    </x-button>
</div>

<div class="max-h-80 overflow-x-auto">
    <x-table>
        <x-table.thead>
            <x-table.tr class="flex items-center px-1">
                <x-table.th class="w-3/12 hidden sm:table-cell">
                    {{ trans('payroll::settings.pay_type') }}
                </x-table.th>

                <x-table.th class="w-6/12 hidden sm:table-cell">
                    {{ trans('payroll::settings.pay_item') }}
                </x-table.th>

                <x-table.th class="w-3/12 hidden sm:table-cell">
                    {{ trans('payroll::settings.amount_type') }}
                </x-table.th>
            </x-table.tr>
        </x-table.thead>

        <x-table.tbody>
            @foreach($pay_items as $item)
                <x-table.tr>
                    <x-table.td class="w-3/12 hidden sm:table-cell">
                        {{ trans('payroll::settings.type.'.$item->pay_type) }}
                    </x-table.td>

                    <x-table.td class="w-6/12 hidden sm:table-cell">
                        <div class="font-medium truncate">{{ $item->pay_item }}</div>
                    </x-table.td>

                    <x-table.td class="w-3/12 hidden sm:table-cell">
                        {{ trans('payroll::settings.type.'.$item->amount_type) }}
                    </x-table.td>

                    <x-table.td class="p-0" override="class">
                        <div class="absolute ltr:right-12 rtl:left-12 -top-4 hidden items-center group-hover:flex">
                            <a class="relative bg-white hover:bg-gray-100 border py-0.5 px-1 cursor-pointer index-actions" @click="onEditPayitem('{{ $item->id }}', '{{trans('general.title.edit', ['type' => trans('payroll::settings.pay_item')])  }}')" >
                                <span class="material-icons-outlined text-purple text-lg">
                                    edit
                                </span>
            
                                <div class="inline-block absolute invisible z-20 py-1 px-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 tooltip-content -top-10 -left-2" data-tooltip-placement="top">
                                    <span>  {{ trans('general.edit') }}</span>
                                    <div class="absolute w-2 h-2 -bottom-1 before:content-[' '] before:absolute before:w-2 before:h-2 before:bg-white before:border-gray-200 before:transform before:rotate-45 before:border before:border-t-0 before:border-l-0" data-popper-arrow></div>
                                </div>
                            </a>

                            <x-delete-button :model="$item" route="payroll.settings.pay-item.destroy" text="payroll::settings.pay_item" />
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>
</div>