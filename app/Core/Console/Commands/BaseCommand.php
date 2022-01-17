<?php

namespace App\Core\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class ProcessTransactions
 *
 * @package App\Transaction\Console\Commands
 */
class BaseCommand extends Command
{
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
    public function handle()
    {
        return $this->process();
    }
}
