<?php

namespace Database\Seeders;

use App\Account\Models\Account;
use App\Acl\Models\Permission;
use App\Acl\Models\PermissionGroup;
use App\Transaction\Models\TransactionType;
use App\User\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class PermissionSeeder
 *
 * @package Database\Seeders
 */
class PermissionSeeder extends Seeder
{
    /**
     * Seed the permissions for the project.
     *
     * @return void
     */
    public function run() : void
    {
        $this->seedAdminPermissions();
        $this->seedPortalPermissions();
    }

    /**
     * Seed the permissions for admin users.
     *
     * @return void
     */
    protected function seedAdminPermissions() : void
    {
        $this->permissions(
            $this->group('Roles'),
            $this->crud('role'),
            'admin'
        );

        $this->permissions(
            $this->group('Admin Users'),
            $this->crud('admin_user'),
            'admin'
        );

        $this->permissions(
            $this->group('Users'),
            $this->crud('user'),
            'admin'
        );

        $this->permissions(
            $this->group('Accounts'),
            $this->crud('account'),
            'admin'
        );

        $this->permissions(
            $this->group('Transactions'),
            $this->crud('transaction'),
            'admin'
        );
    }

    /**
     * Seed the permissions for portal users.
     *
     * @return void
     */
    protected function seedPortalPermissions() : void
    {
        $this->permissions(
            $this->group('Accounts'),
            $this->crud('account')
        );

        $this->permissions(
            $this->group('Transactions'),
            $this->crud('transaction')
        );
    }

    /**
     * @param PermissionGroup $group
     * @param array           $permissions
     * @param string          $guard
     *
     * @return void
     */
    protected function permissions(PermissionGroup $group, $permissions, $guard = 'portal') : void
    {
        foreach ($permissions as $key => $name) {
            $this->permission($group, $name, $guard, $key);
        }
    }

    /**
     * @param PermissionGroup $group
     * @param string          $name
     * @param string          $guard
     * @param string          $key
     *
     * @returnPermission
     */
    protected function permission(PermissionGroup $group, $name, $guard, $key) : Permission
    {
        return Permission::firstOrCreate(['name' => $key, 'guard_name' => $guard], ['group_id' => $group->id, 'label' => $name]);
    }

    /**
     * @param string $name
     *
     * @return PermissionGroup
     */
    protected function group($name) : PermissionGroup
    {
        return PermissionGroup::firstOrCreate(compact('name'));
    }

    /**
     * @param string $suffix
     * @param string $include
     *
     * @return array
     */
    protected function crud(string $suffix, string $include = 'crud') : array
    {
        $include = strtolower($include);

        $name = ucwords(preg_replace('/[_-]+/', ' ', $suffix));

        $permissions = [];

        if (strpos($include, 'c') !== false) {
            $permissions[$suffix . '.create'] = 'Add ' . $name;
        }

        if (strpos($include, 'r') !== false) {
            $permissions[$suffix . '.read'] = 'View ' . $name;
        }

        if (strpos($include, 'u') !== false) {
            $permissions[$suffix . '.update'] = 'Edit ' . $name;
        }

        if (strpos($include, 'd') !== false) {
            $permissions[$suffix . '.delete'] = 'Delete ' . $name;
        }

        return $permissions;
    }
}
