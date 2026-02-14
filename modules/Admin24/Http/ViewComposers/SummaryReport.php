<?php

namespace Modules\Admin24\Http\ViewComposers;

use Illuminate\View\View;

class SummaryReport
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return mixed
     */
    public function compose(View $view): mixed
    {
        // Override the whole file
        return $view->setPath(view('admin24::components.reports.summary')->getPath());
    }
}