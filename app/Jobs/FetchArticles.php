<?php

namespace App\Jobs;

use App\Models\Article;
use App\PracticalDevRequests\ArticleRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class FetchArticles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $current_page;

    private int $results_per_page;

    private bool $spawnNextPage = true;

    public $timeout = 960;

    public $backoff = [60, 90, 120];

    public function __construct(int $current_page, int $results_per_page)
    {
        $this->current_page = $current_page;

        $this->results_per_page = $results_per_page;
    }

    public function retryUntil()
    {
        return now()->addHours(6);
    }

    public function get_current_page(): int
    {
        return $this->current_page;
    }

    public function preventNextPageSpawn(): FetchArticles
    {
        $this->spawnNextPage = false;

        return $this;
    }

    public function handle(): void
    {
        $fetched_articles = collect(ArticleRequest::getArticles($this->current_page, $this->results_per_page));

        if ($fetched_articles->isEmpty()) {
            return;
        }

        $fetched_articles->mapInto(Collection::class)
        ->map(fn ($article_details) => Article::create_from_response($article_details))
        ->each(fn (Article $article) => FetchComments::dispatch($article)->onQueue('comments'));

        self::dispatchIf($this->spawnNextPage, ++$this->current_page, $this->results_per_page);
    }
}
