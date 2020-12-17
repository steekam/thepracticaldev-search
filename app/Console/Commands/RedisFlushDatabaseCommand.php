<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisFlushDatabaseCommand extends Command
{
    protected $signature = 'redis:flushdb';

    protected $description = 'Clear the redis database';

    public function handle(): int
    {
        Redis::command('flushdb');

        $this->info("Cleared redis database");

        return 0;
    }
}
