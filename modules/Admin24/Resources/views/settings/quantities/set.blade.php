<x-layouts.admin>
    <x-slot name="title">{{ trans('admin24::settings.set_quantity') }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="setting" method="POST" route="admin24.settings.quantities.setupdate">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans_choice('admin24::settings.set_quantity', 1) }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.select name="quantity" label="{{ trans('admin24::settings.quantity') }}" :options="$quantities" :selected="old('quantity', setting('admin24.quantity'))"/>

                        <x-form.group.select name="item" label="{{ trans('admin24::settings.item') }}" :options="$items" :selected="old('item', setting('admin24.quantity_item'))"/>
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
