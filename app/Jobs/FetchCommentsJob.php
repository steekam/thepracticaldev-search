<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Comment;
use App\PracticalDevRequests\CommentsRequest;
use Carbon\CarbonInterval;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class FetchCommentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Article $article;

    public $timeout = 960;

    public $maxExceptions = 2;

    public $backoff = [120];

    public function __construct(Article $article)
    {
        $this->article = $article->withoutRelations();
    }

    public function retryUntil()
    {
        return now()->addHours(2);
    }

    public function handle(): void
    {
        try {
            collect(CommentsRequest::getArticleComments($this->article->id))
            ->mapInto(Collection::class)
            ->filter(fn (Collection $comment_details) => ! empty($comment_details->get('user')))
            ->each->put('article_id', $this->article->id)
            ->map(fn (Collection $comment_details) => Comment::create_from_details($comment_details));
        } catch (RequestException $exception) {
            // ? Release back to queue if Retry Later Exception
            if ($exception->response->status() === 429) {
                $this->release(CarbonInterval::minutes(3)->totalSeconds);
                return;
            }
            throw $exception;
        }
    }
}
