<?php

namespace App\Console\Commands;

use App\Models\Comment;
use App\PracticalDevRequests\CommentsRequest;
use Illuminate\Console\Command;

class ClassifyCommentsCommand extends Command
{
    protected $signature = 'classify_comments';

    protected $description = 'Classify comments using the sentiment classification API';

    public function handle(): int
    {
        // TODO: test after modifying model
        
        Comment::unclassified()
        ->chunkById(500, function ($comments) {
            collect(CommentsRequest::getCommentsSentiment($comments))
            ->each(fn (array $response) => Comment::update_sentiment_from_api_response($response));
        });

        return 0;
    }
}
