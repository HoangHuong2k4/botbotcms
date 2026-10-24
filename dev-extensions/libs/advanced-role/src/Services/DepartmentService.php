<?php

namespace Dev\AdvancedRole\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use Exception;
use Dev\AdvancedRole\Repositories\Interfaces\DepartmentInterface;
use Dev\Member\Repositories\Interfaces\MemberInterface;
use Dev\AdvancedRole\Enums\AgentStatusEnum;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\AdvancedRole\Models\Member;

class DepartmentService
{
    protected MemberInterface $memberRepository;
    protected DepartmentInterface $departmentRepository;

    public function __construct(MemberInterface $memberRepository, DepartmentInterface $departmentRepository)
    {
        $this->memberRepository = $memberRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function getRootDepartment($user)
    {
        $dataQ = [
            'parent_id' => null,
            'author_id' => $user->id,
            'author_type' => Member::class,
        ];
        $departmentRoot = $this->departmentRepository->getFirstBy($dataQ);

        if (blank($departmentRoot)) {
            $data = [
                'name' => Str::uuid(),
                'display_name' => "{$user->name}'s Department",
                'parent_id' => null,
                'author_id' => $user->id,
                'author_type' => Member::class,
            ];

            $departmentRoot = $this->departmentRepository->create($data);
        }

        return $departmentRoot;
    }

    public function index($user)
    {
        $departments = advancedRole_get_deep_departments([
            'indent' => '/--',
            'user_id' => $user->id
        ]);
        foreach ($departments as $row) {
            $row->display_name = trim($row->indent_text . ' ' . $row->display_name);
        }
        return $departments;
    }

    public function store($request)
    {
        $rootDepartment = $this->getRootDepartment($request->user());
        if (!blank($request->parent_id)) {
            $rootDepartment = $this->departmentRepository->findById($request->parent_id);
        }

        $department = $this->departmentRepository->create([
            'name' => Str::uuid(),
            'display_name' => $request->name,
            'parent_id' => $rootDepartment->id,
            'author_id' => $request->user()->id,
            'author_type' => Member::class,
        ]);

        return $department;
    }

    public function show($id)
    {
        $department = $this->departmentRepository->getFirstBy([
            'id' => $id
        ]);

        if (blank($department)) {
            throw new Exception(__('Data not found!'));
        }
        return $department;
    }

    public function update($id, $request)
    {
        $department = $this->show($id);
        $rootDepartment = $this->getRootDepartment($request->user());

        if (!blank($request->parent_id)) {
            $rootDepartment = $this->departmentRepository->findById($request->parent_id);
        }

        $department->update([
            'display_name' => $request->name,
            'parent_id' => $rootDepartment->id,
        ]);
        return $department;
    }

    public function deletes($ids, $user)
    {
        foreach ($ids as $id) {
            try {
                $this->destroy($id, $user);
            } catch (\Throwable $th) {
                continue;
            }
        }
    }

    public function destroy($id, $user)
    {
        $rootDepartment = $this->getRootDepartment($user);
        $department = $this->departmentRepository->getFirstBy([
            'id' => $id
        ]);

        if (blank($department)) {
            throw new Exception(__('Data not found!'));
        }

        if ($department->children && $rootDepartment->id != $id) {
            foreach ($department->children as $key => $child) {
                $child->update([
                    'parent_id' => $rootDepartment->id
                ]);
            }
        }
        $department->delete();
    }
}