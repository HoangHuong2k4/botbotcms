<?php

namespace Dev\AdvancedRole\Repositories\Interfaces;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;

interface DepartmentInterface extends RepositoryInterface
{
    public function getAllDepartments(int|string $memberId);
}
