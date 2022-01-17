<?php

namespace Database\Seeders;

use App\Account\Models\Account;
use App\Acl\Models\Permission;
use App\Acl\Models\Role;
use App\AdminUser\Models\AdminUser;
use App\Transaction\Models\Transaction;
use App\Transaction\Models\TransactionType;
use App\User\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class TransactionTypeSeeder
 *
 * @package Database\Seeders
 */
class TransactionTypeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() : void
    {
        $this->store(TransactionType::DEPOSIT, 'Deposits');
        $this->store(TransactionType::WITHDRAWAL, 'Withdrawals');
    }

    /**
     * @param string $name
     *
     * @return \App\Transaction\Models\TransactionType
     */
    protected function store($id, $name) : TransactionType
    {
        return TransactionType::firstOrCreate(compact('id', 'name'));
    }
}
