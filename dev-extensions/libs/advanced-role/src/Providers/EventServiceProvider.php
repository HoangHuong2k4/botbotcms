<?php

namespace Dev\AdvancedRole\Providers;

#region Events

use Dev\AdvancedRole\Events\MemberEvent;
use Dev\AdvancedRole\Events\RoleEvent;
use Dev\AdvancedRole\Events\DepartmentEvent;
#endregion

#region Listeners
use Dev\AdvancedRole\Listeners\RoleListener;
use Dev\AdvancedRole\Listeners\DepartmentListener;
use Dev\AdvancedRole\Listeners\MemberListener;
#endregion

#region Models
use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Models\Department;
use Dev\AdvancedRole\Models\Member;
#endregion

#region Observers
use Dev\AdvancedRole\Observers\RoleObserver;
use Dev\AdvancedRole\Observers\DepartmentObserver;
use Dev\AdvancedRole\Observers\MemberObserver;
#endregion

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RoleEvent::class => [RoleListener::class],
        DepartmentEvent::class => [DepartmentListener::class],
        MemberEvent::class => [MemberListener::class]

    ];

    protected $observers = [
        Role::class => [RoleObserver::class],
        Department::class => [DepartmentObserver::class],
        Member::class => [MemberObserver::class]
    ];
}
