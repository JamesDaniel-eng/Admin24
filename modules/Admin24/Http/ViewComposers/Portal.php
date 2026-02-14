<?php

namespace Modules\Admin24\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Common\Contacts as Clients;

class Portal
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return mixed
     */
    public function compose(View $view): mixed
    {
        return $view->setPath(view('admin24::portal.index')->getPath());
    }
}