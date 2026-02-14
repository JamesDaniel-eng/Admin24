<?php

namespace Modules\CompositeItems\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposer extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            [
                'components.documents.form.line-item'
            ],
            'Modules\CompositeItems\Http\ViewComposers\DocumentItem'
        );

        View::composer(
            [
                'components.documents.template.line-item'
            ],
            'Modules\CompositeItems\Http\ViewComposers\DocumentTemplateItem'
        );

        // // Prefill a debit note when creating from a bill
        // View::composer(
        //     [
        //         'components.documents.form.advanced',
        //     ],
        //     'Modules\CompositeItems\Http\ViewComposers\Document'
        // );

        // View::composer(
        //     [
        //         'components.documents.script',
        //     ],
        //     'Modules\CompositeItems\Http\ViewComposers\DocumentScript'
        // );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
