<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class ArticleCollection extends Collection
{
    public function loadCommentCounts(): ArticleCollection
    {
        $this->loadCount([
            'comments' => fn(Builder $query) => $query->whereNotNull('sentiment_score'), //TODO: temporary until classification job ends
            'comments as positive_comments_count' => function ($query) {
                $query->where('sentiment_score', '>=', 0.5);
            },
            'comments as negative_comments_count' => function ($query) {
                $query->where('sentiment_score', '<', 0.5);
            },
        ]);

        return $this;
    }

    public function sortBasedOn(string $active_sort): ArticleCollection
    {
        if ($active_sort === 'most relevant') {
            return Cache::get('retrieved_articles_in_relevance_order');
        }

        if ($active_sort === 'most popular') {
            return $this->sortByDesc('positive_reactions_count');
        }

        if ($active_sort === 'most positive') {
            return $this->sortByDesc('comments_sum_sentiment_score');
        }

        if ($active_sort === 'newest') {
            return $this->sortByDesc('published_timestamp');
        }

        if ($active_sort === 'oldest') {
            return $this->sortBy('published_timestamp');
        }

        return $this;
    }

}
