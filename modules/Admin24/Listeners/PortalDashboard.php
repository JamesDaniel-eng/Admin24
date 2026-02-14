<?php

namespace Modules\Admin24\Listeners;

use App\Events\Auth\LandingPageShowing as Event;
use App\Traits\Permissions;

class PortalDashboard
{
    use Permissions;

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $user = $event->user;
        
        
        
        
    }
}
