<?php

namespace Database\Seeders;

use App\Account\Models\Account;
use App\Acl\Models\Permission;
use App\Acl\Models\Role;
use App\AdminUser\Models\AdminUser;
use App\Transaction\Models\Transaction;
use App\Transaction\Models\TransactionEvent;
use App\User\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 *
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(TransactionTypeSeeder::class);

        $adminRole = Role::factory()->admin()->create();
        $adminRole->syncPermissions(Permission::where('guard_name', 'admin')->get());

        $userRole = Role::factory()->create();
        $userRole->syncPermissions(Permission::where('guard_name', 'portal')->get());

        $adminUser = AdminUser::factory()->create();
        $user      = User::factory()->create();

        $adminUser->syncRoles([$adminRole]);
        $user->syncRoles([$userRole]);

        $closedAccount = Account::factory()
            ->closed()
            ->for($user)
            ->has(
                Transaction::factory()
                    ->has(TransactionEvent::factory()->count(2))
                    ->count(rand(10, 100))
            )
            ->create();

        $account = Account::factory()
            ->for($user)
            ->has(
                Transaction::factory()
                    ->has(TransactionEvent::factory()->count(2))
                    ->count(rand(10, 100))
            )
            ->create();
    }
}
