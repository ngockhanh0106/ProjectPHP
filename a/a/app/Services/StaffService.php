<?php

namespace App\Services;

use App\Repositories\Staff\StaffRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class StaffService {

    protected StaffRepositoryInterface $staffRepository;

    public function __construct(StaffRepositoryInterface $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    public function getList()
    {
        return $this->staffRepository->getListWithoutSuperAdmin();
    }

    public function find($id)
    {
        return $this->staffRepository->findWithoutSuperAdmin($id);
    }

    public function store($request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $staff = $this->staffRepository->create($data);
        $staff->addRole($data['role_ids']);

        return $staff;
    }

    public function update($request, $id)
    {
        $data = $request->all();
        $staff = $this->staffRepository->findWithoutSuperAdmin($id);
        $staff->update($data);
        $staff->syncRole($data['role_ids']);

        return $staff;
    }

    public function delete($id)
    {
        $staff = $this->staffRepository->findWithoutSuperAdmin($id);
        $staff->delete();

        return $staff;
    }
}
