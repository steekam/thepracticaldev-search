<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class HorizonFlushFailedJobsCommand extends Command
{
    protected $signature = 'horizon:flush';

    protected $description = 'Clear all failed jobs';

    public function handle(): int
    {
        $redis = Redis::connection("horizon");

        foreach($redis->keys("*failed*") as $key) {
            $redis->del(Str::after($key, config('horizon.prefix')));
        }

        $this->info("Cleared all failed jobs successfully.");

        return 0;
    }
}
