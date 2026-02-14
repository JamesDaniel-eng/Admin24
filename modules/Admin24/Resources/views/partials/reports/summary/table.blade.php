@php $grand_total = array_sum($class->footer_totals[$table_key]); @endphp

<div class="w-full overflow-x-scroll large-overflow-unset mb-8 margin-bottom-spacing">
    <table class="w-full small-table-width rp-border-collapse">
        @include($class->views['summary.table.header'])
        @include($class->views['summary.table.body'])
        @include($class->views['summary.table.footer'])
    </table>
</div>