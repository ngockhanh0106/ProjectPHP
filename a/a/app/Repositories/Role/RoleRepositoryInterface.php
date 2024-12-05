<?php

namespace App\Repositories\Role;

interface RoleRepositoryInterface
{
    public function getListWithoutSuperAdmin();

    public function findWithoutSuperAdmin($id);
}
