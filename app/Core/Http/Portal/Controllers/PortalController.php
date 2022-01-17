<?php

namespace App\Core\Http\Portal\Controllers;

use App\Core\Http\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PortalController
 *
 * @package App\Core\Http\Controllers
 */
abstract class PortalController extends Controller
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function canManage(Model $model)
    {
        if (!user()->canManage($model)) {
            throw new AuthenticationException('You do not have permission to see this');
        }
    }
}
