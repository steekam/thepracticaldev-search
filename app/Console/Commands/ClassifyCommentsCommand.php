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
        $chunk_size = 1000;
        $current_chunk = 1;
        $total_chunks = 0;

        Comment::unclassified()
        ->tap(function($comments) use (&$total_chunks, &$chunk_size) {
            $total_chunks = ceil($comments->count()/$chunk_size);
            $this->info("Found {$comments->count()} unclassified comments.");
            $this->info("Creating {$total_chunks} chunks.");
        })
        ->chunkById(1000, function ($comments) use (&$total_chunks, &$current_chunk) {
            $this->info("Sending {$current_chunk}/{$total_chunks} chunk to model API");

            collect(CommentsRequest::getCommentsSentiment($comments))
            ->each(fn (array $response) => Comment::update_sentiment_from_api_response($response));

            $current_chunk++;
        });
        $this->info("Done!");

        return 0;
    }
}
