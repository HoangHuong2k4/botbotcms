<?php

namespace Dev\AdvancedRole\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Http\Request;
use Dev\AdvancedRole\Http\Requests\v1\StoreDepartmentRequest;
use Dev\AdvancedRole\Http\Resources\DepartmentListResource;
use Dev\AdvancedRole\Repositories\Interfaces\DepartmentInterface;
use Symfony\Component\HttpFoundation\Response;
use Dev\AdvancedRole\Http\Resources\DepartmentResource;
use Dev\AdvancedRole\Services\DepartmentService;

class DepartmentController extends Controller
{
    public DepartmentInterface $departmentRepository;
    public DepartmentService $departmentService;

    public function __construct(DepartmentInterface $departmentRepository, DepartmentService $departmentService) {
        $this->departmentRepository = $departmentRepository;
        $this->departmentService = $departmentService;
    }

    public function index(Request $request, BaseHttpResponse $response) {
        try {
            $departments = $this->departmentService->index($request->user());
            return $response
                ->setData(DepartmentListResource::collection($departments));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(StoreDepartmentRequest $request, BaseHttpResponse $response) {
        try {
            $department = $this->departmentService->store($request);
            return $response
                ->setData(new DepartmentResource($department))
                ->setMessage('Create successfully');
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id, BaseHttpResponse $response) {
        try {
            $department = $this->departmentService->show($id);
            return $response
                ->setData(new DepartmentResource($department));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, Request $request, BaseHttpResponse $response) {
        try {
            $department = $this->departmentService->update($id, $request);
            return $response
                ->setData(new DepartmentResource($department))
                ->setMessage('Update successfully');
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id, Request $request, BaseHttpResponse $response) {
        try {
            $this->departmentService->destroy($id, $request->user());
            return $response
                ->setMessage(__('Destroy successfully!'))
                ->setCode(Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response) {
        try {
            $ids = $request->input('ids');
            if (empty($ids)) {
                return $response
                    ->setMessage(trans('core/base::notices.no_select'));
            }
            $this->departmentService->deletes($ids, $request->user());
            return $response
                ->setMessage(__('Destroy successfully!'));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
