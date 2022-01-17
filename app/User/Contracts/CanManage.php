<?php

namespace App\User\Contracts;

use App\User\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class CanManage
 *
 * @package App\User\Contracts
 */
interface CanManage
{
    /**
     * Check if the passed in user can manage this resource
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return mixed
     */
    public function canManage(Authenticatable $user);
}
