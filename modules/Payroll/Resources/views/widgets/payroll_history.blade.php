<div id="widget-{{ $class->model->id }}" class="w-full my-8 px-12">
    @include($class->views['header'], ['header_class' => ''])

    <div class="flex flex-col lg:flex-row mt-3">
        <div class="w-full lg:w-11/12">
            {!! $chart->container() !!}
        </div>

        <div class="w-full lg:w-1/12 mt-11">
            <div class="flex flex-col items-center justify-between">
                <div class="flex justify-end lg:block text-lg">{{ $totals['outgoing'] }}</div>
                
                <span class="text-red text-xs">{{ trans('general.outgoing') }}</span>
            </div>
        </div>
    </div>
</div>

@push('body_scripts')
    {!! $chart->script() !!}
@endpush
