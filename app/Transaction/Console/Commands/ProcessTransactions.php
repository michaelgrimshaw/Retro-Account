<?php

namespace App\Transaction\Console\Commands;

use App\Core\Console\Commands\BaseCommand;
use App\Transaction\Models\Transaction;

/**
 * Class ProcessTransactions
 *
 * @package App\Transaction\Console\Commands
 */
class ProcessTransactions extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes pending transactions to account balance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function process()
    {
        foreach (Transaction::isPending()->isTransactionToProcess()->orderBy('transaction_date', 'asc')->get() as $transaction) {
            $transaction->processTransaction();
        }
    }
}
