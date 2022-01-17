<?php

namespace App\Transaction\Observers;

use App\Transaction\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TransactionObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param  Transaction $transaction
     * @return void
     */
    public function creating(Transaction $transaction)
    {
        $transaction->reference = 't-' . strtolower(Str::random(6));
    }

    /**
     * Handle the User "created" event.
     *
     * @param  Transaction $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $transaction->transactionEvents()->create(
            [
                'name'         => 'Pending',
                'output'       => 'Transaction is Pending',
                'data'         => [],
                'triggered_at' => Carbon::now(),
            ]
        );

        if ($transaction->transaction_date->lte(Carbon::now())) {
            $transaction->processTransaction();
        }
    }
}
