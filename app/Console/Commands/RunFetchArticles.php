<?php

namespace App\Console\Commands;

use App\Jobs\FetchArticlesJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RunFetchArticles extends Command
{
    protected $signature = 'fetch_articles
    {--p|page=1 : The starting current page}
    {--r|results=100 : The results per page}
    {--currentonly : Only dispatch the current page}
    {--continue : Only dispatch the current page}';

    protected $description = 'Dispatch the FetchArticles job';

    public function handle(): int
    {
        $page = $this->option('page');
        $results_per_page = $this->option('results');

        if ($this->option('continue')) {
            $stored_values = Redis::hgetall('last_successful_fetch_articles_job');
            $page = $stored_values['page'] + 1;
            $results_per_page = $stored_values['results_per_page'];
        }

        $this->info("Fetching page {$page} with {$results_per_page} results per page");

        $fetch_articles_job = new FetchArticlesJob($page, $results_per_page);

        if ($this->option('currentonly')) {
            $fetch_articles_job->preventNextPageSpawn();
        }

        dispatch($fetch_articles_job);

        return 0;
    }
}
