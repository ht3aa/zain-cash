<?php

namespace Ht3aa\ZainCash\Commands;

use Illuminate\Console\Command;

class ZainCashCommand extends Command
{
    public $signature = 'zain-cash';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
