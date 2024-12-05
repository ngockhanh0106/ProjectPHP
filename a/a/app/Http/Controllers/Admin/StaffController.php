<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaffStoreRequest;
use App\Http\Requests\Admin\StaffUpdateRequest;
use App\Services\RoleService;
use App\Services\StaffService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    protected StaffService $staffService;
    protected RoleService $roleService;

    public function __construct(StaffService $staffService, RoleService $roleService)
    {
        $this->staffService = $staffService;
        $this->roleService = $roleService;
    }

    public function index()
    {
        $staffs = $this->staffService->getList();
        return view('admin.pages.staff.index', compact('staffs'));
    }

    public function create()
    {
        $roles = $this->roleService->getList();
        return view('admin.pages.staff.create', compact('roles'));
    }

    public function store(StaffStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->staffService->store($request);
            DB::commit();

            return redirect()->route('admin.staffs.index')->with('message-success', 'Thêm nhân viên thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.staffs.index')->with('message-failed', 'Thêm nhân viên thất bại!');
        }
    }

    public function edit($id)
    {
        $staff = $this->staffService->find($id);
        $roles = $this->roleService->getList();

        return view('admin.pages.staff.edit', compact('staff', 'roles'));
    }

    public function update(StaffUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->staffService->update($request, $id);
            DB::commit();

            return redirect()->route('admin.staffs.index')->with('message-success', 'Sửa nhân viên thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.staffs.index')->with('message-failed', 'Sửa nhân viên thất bại!');
        }
    }
}
