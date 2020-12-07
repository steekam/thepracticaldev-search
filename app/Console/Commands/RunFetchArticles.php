<?php

namespace App\Console\Commands;

use App\Jobs\FetchArticles;
use Carbon\CarbonInterface;
use Illuminate\Console\Command;

class RunFetchArticles extends Command
{
    protected $signature = 'fetch_articles
    {--p|page=1 : The starting current page}
    {--results=200 : The results per page}
    {--currentonly : Only dispatch the current page}';

    protected $description = 'Dispatch the FetchArticles job';

    public function handle(): int
    {
        $fetch_articles_job = new FetchArticles(
            $this->option("page"),
            $this->option("results")
        );

        if ($this->option("currentonly")) {
            $fetch_articles_job->preventNextPageSpawn();
        }

        dispatch($fetch_articles_job);

        return 0;
    }
}
