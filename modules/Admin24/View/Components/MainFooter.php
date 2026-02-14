<?php

namespace Modules\Admin24\View\Components;

use App\Abstracts\View\Component;

class MainFooter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('admin24::components.footer');
    }
}
