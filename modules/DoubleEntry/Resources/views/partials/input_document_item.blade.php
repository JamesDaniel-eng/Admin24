<el-popover
    popper-class="p-0 h-0"
    placement="bottom"
    width="300"
    
    trigger="click">
    @include('double-entry::partials.account_select')

    <x-button
        type="button"
        class="relative absolute -top-2 flex items-center text-right border-0 p-0 pr-4 text-xs text-purple"
        slot="reference"
        override="class"
    >
        <span class="border-b border-transparent transition-all hover:border-purple">
            {{ trans('double-entry::general.edit_account', ['type' => trans($document_type_class)]) }}
        </span>
    </x-button>
</el-popover>
