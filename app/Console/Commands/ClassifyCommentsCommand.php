<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClassifyCommentsCommand extends Command
{
    protected $signature = 'classify_comments';

    protected $description = 'Classify comments using the sentiment classification API';

    public function handle(): int
    {
        // ! Check LazyCollections docs for further optimizations.
        // ? Fetch comments without sentiment score <use the cursor method>
        // ? Send to API in batches of 500

        return 0;
    }
}
