<?php

namespace App\Acl\Models;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role
 *
 * @package App\Acl\Models
 */
class Role extends SpatieRole implements RoleContract
{
    use SoftDeletes,
        HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return RoleFactory::new();
    }

    /**
     * @return string
     */
    public function getTypeAttribute()
    {
        return $this->guard_name == 'admin' ? 'Admin' : 'Portal';
    }
}
