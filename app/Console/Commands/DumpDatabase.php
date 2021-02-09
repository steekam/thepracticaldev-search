<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DumpDatabase extends Command
{
    protected $signature = 'db:dump';

    protected $description = 'Dumps the database into an sql file';

    public function handle(): int
    {
        $mysql_details = config('database.connections.mysql');

        \Spatie\DbDumper\Databases\MySql::create()
            ->setDbName($mysql_details['database'])
            ->setUserName($mysql_details['username'])
            ->setPassword($mysql_details['password'])
            ->dumpToFile('mysql_dump.sql');

        return 0;
    }
}
