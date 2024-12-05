<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Repositories\Base\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getListWithoutSuperAdmin()
    {
        return $this->model->with('permissions')
            ->withoutSuperAdmin()->paginate(10);
    }

    public function findWithoutSuperAdmin($id)
    {
        return $this->model->with('permissions')
            ->withoutSuperAdmin()->findOrFail($id);
    }
}
