<x-layouts.admin>
    <x-slot name="title">{{ trans('admin24::settings.new_quantity') }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="setting" method="POST" route="admin24.settings.quantities.store">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans_choice('admin24::settings.new_quantity', 1) }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="name" label="{{ trans('admin24::settings.quantity_name') }}" value="{{ old('transfer_order_prefix', setting('admin24.transfer_order_prefix')) }}" />

                        <x-form.group.select name="item_id" label="{{ trans('admin24::settings.item') }}" :options="$items" :selected="old('item', setting('admin24.quantity_item'))"/>

                        <x-form.group.number name="ratio" label="{{ trans('admin24::settings.unit') }}" value="{{ old('quantity_ratio', setting('admin24.quantity_ratio')) }}" />

                        <x-form.group.number name="multiplier" label="{{ trans('admin24::settings.prods') }}" value="{{ old('quantity_multiplier', setting('admin24.quantity_multiplier')) }}" />
                    </x-slot>
                </x-form.section>

                @can('update-inventory-settings')
                    <x-form.section>
                        <x-slot name="foot">
                            <x-form.buttons :cancel="url()->previous()" />
                        </x-slot>
                    </x-form.section>
                @endcan
            </x-form>
        </x-form.container>
    </x-slot>
    <x-script alias="inventory" file="settings" />
</x-layouts.admin>
