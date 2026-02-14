<x-layouts.admin>
    <x-slot name="title">{{ trans_choice('payroll::general.pay_calendars', 2) }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans_choice('payroll::general.pay_calendars', 2) }}"
        icon="groups"
        route="payroll.pay-calendars.index"
    ></x-slot>

    <x-slot name="buttons">
        @can('create-payroll-pay-calendars')
            <x-link href="{{ route('payroll.pay-calendars.create') }}" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('payroll::general.pay_calendars', 1)]) }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="moreButtons">
        <x-dropdown id="dropdown-more-actions">
            <x-slot name="trigger">
                <span class="material-icons pointer-events-none">more_horiz</span>
            </x-slot>

            @can('create-payroll-pay-calendars')
                <x-dropdown.link href="{{ route('import.create', ['payroll', 'pay-calendars']) }}">
                    {{ trans('import.import') }}
                </x-dropdown.link>
            @endcan

            <x-dropdown.link href="{{ route('payroll.pay-calendars.export', request()->input()) }}">
                {{ trans('general.export') }}
            </x-dropdown.link>
        </x-dropdown>
    </x-slot>

    <x-slot name="content">
        @if ($pay_calendars->count() || request()->get('search', false))
            <x-index.container>
                <x-index.search
                    search-string="Modules\Payroll\Models\PayCalendar\PayCalendar"
                    bulk-action="Modules\Payroll\BulkActions\PayCalendars"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr>
                            <x-table.th kind="bulkaction">
                                <x-index.bulkaction.all />
                            </x-table.th>

                            <x-table.th class="w-6/12">
                                <x-sortablelink column="name" title="{{ trans('general.name') }}" />
                            </x-table.th>

                            <x-table.th class="w-2/12">
                                <x-sortablelink column="type" title="{{ trans_choice('general.types', 1) }}" />
                            </x-table.th>

                            <x-table.th class="w-4/12" kind="right">
                                <x-sortablelink column="pay_day_mode" title="{{ trans('payroll::pay-calendars.pay_day_mode') }}" />
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach($pay_calendars as $item)
                            <x-table.tr href="{{ route('payroll.pay-calendars.edit', $item->id) }}" data-table-list class="relative flex items-center border-b hover:bg-gray-100 px-1 group">
                                <x-table.td kind="bulkaction">
                                    <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->name }}" />
                                </x-table.td>

                                <x-table.td class="w-6/12 truncate">
                                    {{ $item->name }}
                                </x-table.td>

                                <x-table.td class="w-2/12 text-left">
                                    {{ trans('payroll::general.' . $item->type) }}
                                </x-table.td>

                                <x-table.td class="w-4/12 text-left" kind="right">
                                    {{ trans('payroll::general.' . $item->pay_day_mode) }}
                                </x-table.td>

                                <x-table.td kind="action">
                                    <x-table.actions :model="$item" />
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.tbody>
                </x-table>

                <x-pagination :items="$pay_calendars" />
            </x-index.container>
        @else
            <x-empty-page group="payroll" page="pay-calendars" docs-category="hr"/>
        @endif
    </x-slot>

    <x-script alias="payroll" file="pay-calendars" />
</x-layouts.admin>