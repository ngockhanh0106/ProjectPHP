<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const SUPER_ADMIN = 'super_admin';
    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_admin',
            'admin_id',
            'role_id'
        );
    }

    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }

    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }
        return false;
    }

    public function isSuperAdmin()
    {
        return $this->hasRole(self::SUPER_ADMIN);
    }

    public function scopeWithoutSuperAdmin($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', '!=', self::SUPER_ADMIN);
        });
    }

    public function addRole($roleIds)
    {
        return $this->roles()->attach($roleIds);
    }

    public function syncRole($roleIds)
    {
        return $this->roles()->sync($roleIds);
    }
}
