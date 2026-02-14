@php
    $is_print = request()->routeIs('reports.print');
@endphp

@include($class->views['detail.content.header'])

@foreach($class->tables as $table_key => $table_name)
    <div class="flex flex-col lg:flex-row mt-12">
        @include($class->views['summary.table'])
    </div>
@endforeach

@include($class->views['summary.content.footer'])
