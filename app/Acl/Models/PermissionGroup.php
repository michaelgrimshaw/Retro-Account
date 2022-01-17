<?php

namespace App\Acl\Models;

use App\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class PermissionGroup
 *
 * @package App\Acl\Models
 */
class PermissionGroup extends BaseModel
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'acl_permission_groups';


    /**
     * Get permissions
     *
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(
            Permission::class,
            'group_id'
        );
    }

    /**
     * @param string $guard
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function permissionsWithGuard($guard)
    {
        return $this->permissions()->where('guard_name', $guard)->get();
    }
}
