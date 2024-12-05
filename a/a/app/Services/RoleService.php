<?php

namespace App\Services;

use App\Repositories\Role\RoleRepositoryInterface;

class RoleService
{
    protected RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getList()
    {
        return $this->roleRepository->getListWithoutSuperAdmin();
    }

    public function store($request)
    {
        $data = $request->all();
        $role = $this->roleRepository->create($data);
        $role->addPermission($data['permission_ids']);

        return $role;
    }

    public function find($id)
    {
        return $this->roleRepository->findWithoutSuperAdmin($id);
    }

    public function update($request, $id)
    {
        $data = $request->all();
        $role = $this->roleRepository->findWithoutSuperAdmin($id);
        $role->update($data);
        $role->syncPermission($data['permission_ids']);

        return $role;
    }

    public function delete($id)
    {
        $role = $this->roleRepository->findWithoutSuperAdmin($id);
        $role->delete();

        return $role;
    }
}
