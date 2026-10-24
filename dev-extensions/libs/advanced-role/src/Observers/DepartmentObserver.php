<?php

namespace Dev\AdvancedRole\Observers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Dev\AdvancedRole\Events\DepartmentEvent;
use Dev\AdvancedRole\Models\Department;

use Throwable;

class DepartmentObserver
{

    private $logger = 'advanced-role';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        try {
            $this->logger = apps_log_channel($this->logger);
        } catch (Throwable $th) {
            Log::channel($this->logger)->error($th->getMessage());
            Log::channel($this->logger)->error($th->getTraceAsString());
        }
    }

    public function setLog($logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function saving(Department $department)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function creating(Department $department)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
        $department->name = Str::slug($department->name);

        // $department->author_id = $department->author_id ?: auth('member')->id();
        // $department->author_type = $department->author_type ?: User::class;
    }

    public function updated(Department $department)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function created(Department $department)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);

        // if (!app()->runningInConsole()) {
        //     event(new DepartmentEvent($department, $department->assigned, 'DepartmentAssigned'));
        // }
    }

    public function deleting(Department $department)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function deleted(Department $department)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }
}
