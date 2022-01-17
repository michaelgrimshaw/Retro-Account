<?php

namespace App\Acl\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Contracts\Permission as PermissionContract;

/**
 * Class Permission
 *
 * @package App\Acl\Models
 */
class Permission extends SpatiePermission implements PermissionContract
{
    /**
     * Get the group the permission belongs to
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(PermissionGroup::class, 'group_id');
    }
}
