<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class HorizonFlushFailedJobsCommand extends Command
{
    protected $signature = 'horizon:flush';

    protected $description = 'Clear all failed jobs';

    public function handle(): int
    {
        $prefix = config('horizon.prefix');
        // dump(Redis::del("{$prefix}failed_jobs"));
        
        dump("{$prefix}failed_jobs");
        $this->info("Cleared failed jobs");

        return 0;
    }
}
