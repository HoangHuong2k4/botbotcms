<?php

namespace Dev\AdvancedRole\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Models\Scope;
use Dev\AdvancedRole\Models\Permission;
use Dev\AdvancedRole\Models\Department;
use Dev\AdvancedRole\Models\Member;

class RoleMember extends Pivot
{
    protected $table = 'app__role_members';

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
