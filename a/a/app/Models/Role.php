<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Role extends Model
{
    use HasFactory;
    use HasSlug;
    public const SUPER_ADMIN = 'super_admin';
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'display_name',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('display_name')
            ->saveSlugsTo('name')
            ->usingSeparator('_');
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'permission_role',
            'role_id',
            'permission_id'
        );
    }

    public function staffs()
    {
        return $this->belongsToMany(
            Admin::class,
            'role_admin',
            'role_id',
            'admin_id'
        );
    }

    public function scopeWithoutSuperAdmin($query)
    {
        return $query->where('name', '!=', self::SUPER_ADMIN);
    }

    public function addPermission($permissionIds)
    {
        return $this->permissions()->attach($permissionIds);
    }

    public function syncPermission($permissionIds)
    {
        return $this->permissions()->sync($permissionIds);
    }
}
