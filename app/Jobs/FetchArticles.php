<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Comment;
use App\PracticalDevRequests\ArticleRequest;
use App\PracticalDevRequests\CommentsRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class FetchArticles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $current_page;

    private int $results_per_page;

    private bool $spawnNextPage = true;

    public function __construct(int $current_page, int $results_per_page = 50)
    {
        $this->current_page = $current_page;

        $this->results_per_page = $results_per_page;
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

    private function console_log(string $info): void
    {
        if(App::runningInConsole()){
            echo "[".now()."] {$info} \n";
        }
    }

    public function handle(): void
    {
        $this->console_log("Fetching articles from dev_to API");

        $fetched_articles = collect(ArticleRequest::getArticles($this->current_page, $this->results_per_page));

        if ($fetched_articles->isEmpty()) {
            return;
        }

        $fetched_articles->mapInto(Collection::class)
        ->map(fn ($article_details) => Article::create_from_response($article_details))
        ->each(function (Article $article) {
            $this->console_log("Fetching comments");

            collect(CommentsRequest::getArticleComments($article->id))
            ->mapInto(Collection::class)
            ->filter(fn (Collection $comment_details) => !empty($comment_details->get('user')))
            ->each->put('article_id', $article->id)
            ->map(fn (Collection $comment_details) => Comment::create_from_details($comment_details));

            $this->console_log("Classifying comments");

            $article->classify_comments();
        });

        self::dispatchIf($this->spawnNextPage, ++$this->current_page, $this->results_per_page);
    }
}
