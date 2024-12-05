<?php

namespace App\Repositories\Staff;

interface StaffRepositoryInterface 
{
    public function getListWithoutSuperAdmin();

    public function findWithoutSuperAdmin($id);
}