<?php

namespace Dev\AdvancedRole\Listeners;

use Dev\AdvancedRole\Events\DepartmentEvent;

class DepartmentListener
{

    /**
     * Handle the event.
     *
     * @param DepartmentEvent $event
     * @return void
     */

    public function handle(DepartmentEvent $event)
    {
        if ($event->notificationName == 'DepartmentAssigned') {
        }
    }
}
