<?php

namespace Dev\AdvancedRole\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Dev\AdvancedRole\Models\Department;

class DepartmentEvent
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notifyUser;
    public $notificationName;
    /**
     * @var Department
     */
    public $department;

    public function __construct(Department $department, $notifyUser, $notificationName)
    {
        $this->department = $department;
        $this->notifyUser = $notifyUser;
        $this->notificationName = $notificationName;
    }
}
