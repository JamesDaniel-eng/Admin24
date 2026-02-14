<x-layouts.admin>
    <x-slot name="title">{{ trans('admin24::settings.prod_quantities') }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans('admin24::settings.prod_quantities') }}"
        icon="scale"
        route="admin24.settings"
    ></x-slot>

    <x-slot name="buttons">
        <x-link href="{{ route('admin24.settings.quantities.add') }}" kind="primary" id="index-more-actions-new-company">
            {{ trans('admin24::settings.new_quantity') }}
        </x-link>
        <x-link href="{{ route('admin24.settings.quantities.set') }}" kind="normal" id="index-more-actions-new-company">
            {{ trans('admin24::settings.set_quantity') }}
        </x-link>
    </x-slot>
    <x-slot name="content">
        <x-form.container>
            <x-form.section>
                <x-slot name="head">
                    <x-form.section.head title="{{ trans('admin24::settings.prod_quantities') }}" description="Here you can manage all <b>Production Quantites</b>." />
                </x-slot>
            </x-form.section>
        </x-form.container>
        <x-index.container>
            <x-table>
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th class="w-2/12 sm:w-4/12">
                            <x-sortablelink column="id" title="{{ trans('admin24::settings.quantity') }}" />
                        </x-table.th>

                        <x-table.th class="w-4/12 sm:w-6/12">
                            <x-sortablelink column="name" title="{{ trans('admin24::settings.associated_item') }}" />
                        </x-table.th>

                        <x-table.th class="w-4/12" hidden-mobile>
                            <x-sortablelink column="type" title="{{ trans('admin24::settings.ratio') }}" />
                        </x-table.th>

                        <x-table.th class="w-2/12" hidden-mobile>
                            <x-sortablelink column="type" title="{{ trans('admin24::settings.quantity') }}" />
                        </x-table.th>
                    </x-table.tr>
                </x-table.thead>

                <x-table.tbody>
                    @if(!empty($quantities))
                        @foreach($quantities as $item)
                            <x-table.tr href="{{ route('admin24.settings.quantities.edit', $item->id) }}">
                                <x-table.td class="w-2/12 sm:w-4/12">
                                    <div class="font-bold truncate">
                                        {{ $item->name }}
                                    </div>
                                </x-table.td>

                                <x-table.td class="w-4/12 sm:w-6/12">
                                    @if(!empty($item->item_id))
                                        <x-link href="{{ route('inventory.items.show', $item->item_id) }}" class="border-black border-b border-dashed" override="class">
                                            {{ $item->item_name }}
                                        </x-link>
                                    @endif
                                </x-table.td>

                                <x-table.td class="w-4/12 text-center" hidden-mobile>
                                    {{ $item->ratio }}
                                </x-table.td>

                                <x-table.td class="w-2/12 text-center" hidden-mobile>
                                    {{ $item->multiplier }}
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    @endif
                </x-table.tbody>
            </x-table>
            
        </x-index.container>
    </x-slot>

</x-layouts.admin>
