<?php

namespace App\Account\Observers;

use App\Account\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AccountObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param  Account $account
     * @return void
     */
    public function creating(Account $account)
    {
        $account->reference = 'lq-' . strtolower(Str::random(6));
        $account->overdraft = 250;
        $account->user_id   = 1;
        $account->opened_at = Carbon::now();
    }
}
