<?php

namespace App\Jobs;

use App\Models\Article;
use App\PracticalDevRequests\ArticleRequest;
use Carbon\CarbonInterval;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class FetchArticlesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $current_page;

    private int $results_per_page;

    private bool $spawnNextPage = true;

    public $timeout = 1260;

    public $maxExceptions = 2;

    public $backoff = [180];

    public function __construct(int $current_page, int $results_per_page)
    {
        $this->current_page = $current_page;

        $this->results_per_page = $results_per_page;
    }

    public function retryUntil()
    {
        return now()->addHours(2);
    }

    public function get_current_page(): int
    {
        return $this->current_page;
    }

    public function preventNextPageSpawn(): self
    {
        $this->spawnNextPage = false;

        return $this;
    }

    public function handle(): void
    {
        try {
            $fetched_articles = collect(ArticleRequest::getArticles($this->current_page, $this->results_per_page));

            if ($fetched_articles->isEmpty()) {
                return;
            }

            $fetched_articles->mapInto(Collection::class)
            ->map(fn ($article_details) => Article::create_from_response($article_details))
            ->each(fn (Article $article) => FetchCommentsJob::dispatch($article)->onQueue('comments'));

            Redis::hmset(
                'last_successful_fetch_articles_job',
                'current_page',
                $this->current_page,
                'results_per_page',
                $this->results_per_page
            );

            self::dispatchIf($this->spawnNextPage, ++$this->current_page, $this->results_per_page);
        } catch (RequestException $exception) {
             if ($exception->response->status() === 429) {
                $this->release(CarbonInterval::minutes(4)->totalSeconds);
                return;
            }
            throw $exception;
        }
    }
}
