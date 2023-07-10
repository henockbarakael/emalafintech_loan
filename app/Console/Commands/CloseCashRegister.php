<?php

namespace App\Console\Commands;

use App\Models\CashRegister;
use Illuminate\Console\Command;

class CloseCashRegister extends Command
{
    protected $signature = 'cash-register:close';

    protected $description = 'Close the cash register';

    public function handle()
    {
        $cashRegister = CashRegister::firstOrFail();
        $cashRegister->close();
        $this->info('Cash register closed');
    }
}
