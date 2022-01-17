<?php

namespace Tests\Traits;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Auth\Access\Gate;

/**
 * Trait InteractsWithPermissions
 *
 * @package Tests\Traits
 */
trait InteractsWithPermissions
{
    /**
     * Permissions to be denied for the current test
     *
     * @var array
     */
    protected $deniedPermissions = [];

    /**
     * Initialise the trait
     *
     * @return void
     */
    public function setupInteractsWithPermissionsTrait()
    {
        $this->seed('PermissionSeeder');

        $this->app['events']->listen(Authenticated::class, function (Authenticated $event) {
            if ($event->guard === 'portal') {
                $this->configureGate();
            }
        });
    }

    /**
     * Configure gate callback
     *
     * @return void
     */
    protected function configureGate()
    {
        app(Gate::class)->before(function ($user, $ability) {
            return !in_array($ability, $this->deniedPermissions);
        });
    }

    /**
     * Force a denial to be returned if the given permission is requested
     *
     * @param $permission
     *
     * @return $this
     */
    protected function denyPermission($permission)
    {
        $this->denyPermissions($permission);

        return $this;
    }

    /**
     * Force a denial to be returned if any of the given permissions are requested
     *
     * @param $permissions
     *
     * @return $this
     */
    protected function denyPermissions(...$permissions)
    {
        $this->deniedPermissions = array_merge($this->deniedPermissions, (array) $permissions);

        return $this;
    }
}
