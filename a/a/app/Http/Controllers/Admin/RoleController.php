<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleStoreRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Models\Permission;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getList();
        return view('admin.pages.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.pages.role.create', compact('permissions'));
    }

    public function store(RoleStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->roleService->store($request);
            DB::commit();

            return redirect()->route('admin.roles.index')->with('message-success', 'Thêm role thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.roles.index')->with('message-failed', 'Thêm role thất bại!');
        }
    }

    public function edit($id)
    {
        $permissions = Permission::all();
        $role = $this->roleService->find($id);
        return view('admin.pages.role.edit', compact('permissions', 'role'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->roleService->update($request, $id);
            DB::commit();

            return redirect()->route('admin.roles.index')->with('message-success', 'Sửa role thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.roles.index')->with('message-failed', 'Sửa role thất bại!');
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->roleService->delete($id);
            DB::commit();

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'xoá role thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'xoá role thất bại!'
            ]);
        }
    }
}
