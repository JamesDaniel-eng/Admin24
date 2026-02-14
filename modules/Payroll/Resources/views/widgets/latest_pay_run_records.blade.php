<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-4">
    @include($class->views['header'], ['header_class' => 'border-bottom-0'])

    @if ($payrolls->count())
        <x-table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th class="w-5/12 sm:w-3/12">
                        <x-slot name="first">
                            {{ trans('general.name') }}
                        </x-slot>
                        <x-slot name="second">
                            {{ trans('payroll::run-payrolls.payment_date') }}
                        </x-slot>
                    </x-table.th>

                    <x-table.th class="w-3/12" hidden-mobile>
                        <x-slot name="first">
                            {{ trans('payroll::run-payrolls.from_date') }}
                        </x-slot>
                        <x-slot name="second">
                            {{ trans('payroll::run-payrolls.to_date') }}
                        </x-slot>
                    </x-table.th>
                    
                    <x-table.th class="w-4/12 sm:w-3/12">
                        {{ trans_choice('general.statuses', 1) }}
                    </x-table.th>

                    <x-table.th class="w-3/12" kind="right">
                        <x-slot name="first">
                            {{ trans_choice('payroll::general.employees', 2) }}
                        </x-slot>
                        <x-slot name="second">
                            {{ trans('general.amount') }}
                        </x-slot>
                    </x-table.th>

                </x-table.tr>
            </x-table.thead>

            <x-table.tbody>
                @foreach($payrolls as $item)
                    <x-table.tr>
                        <x-table.td class="w-5/12 sm:w-3/12">
                            <x-slot name="first" class="flex items-center font-bold" override="class">
                                <div class="truncate">
                                    {{ $item->name }}
                                </div>
                            </x-slot>
                            <x-slot name="second" class="font-normal truncate" override="class">
                                <x-date date="{{ $item->payment_date }}" />
                            </x-slot>
                        </x-table.td>

                        <x-table.td class="w-3/12" hidden-mobile>
                            <x-slot name="first" class="flex items-center font-bold" override="class">
                                <div class="truncate">
                                    <x-date date="{{ $item->from_date }}" />
                                </div>
                            </x-slot>
                            <x-slot name="second" class="font-normal truncate" override="class">
                                <x-date date="{{ $item->to_date }}" />
                            </x-slot>
                        </x-table.td>

                        <x-table.td class="w-4/12 sm:w-3/12">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-xl bg-{{ $item->status_label }} text-text-{{ $item->status_label }}">
                                {{ trans('payroll::run-payrolls.status.' . $item->status) }}
                            </span>
                        </x-table.td>

                        <x-table.td class="w-3/12" kind="right">
                            <x-slot name="first">
                                {{ $item->employees->count() }}
                            </x-slot>
                            <x-slot name="second">
                                <x-money :amount="$item->amount" :currency="$item->currency_code" convert />
                            </x-slot>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table>
    @else
        <h5 class="text-center">{{ trans('general.no_records') }}</h5>
    @endif

</div>
