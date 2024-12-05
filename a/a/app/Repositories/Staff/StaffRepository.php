<?php

namespace App\Repositories\Staff;

use App\Models\Admin;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Staff\StaffRepositoryInterface;

class StaffRepository extends BaseRepository implements StaffRepositoryInterface
{
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    public function getListWithoutSuperAdmin()
    {
        return $this->model->with('roles')->withoutSuperAdmin()->paginate(10);
    }

    public function findWithoutSuperAdmin($id)
    {
        return $this->model->with('roles')->withoutSuperAdmin()->findOrFail($id);
    }
}
