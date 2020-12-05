<?php

namespace App\PracticalDevRequests;

class ArticleRequest extends BaseRequest
{
    public static function getArticles(int $current_page, int $results_per_page = 500)
    {
        return self::request()
            ->get(self::endpoint('/articles'), [
                'top' => 1095, // last 3 years
                'per_page' => $results_per_page,
                'page' => $current_page,
            ])->throw()
            ->json();
    }

    public static function getSingleArticle(int $article_id)
    {
        return self::request()
            ->get(self::endpoint('/articles/'.$article_id))
            ->throw()
            ->json();
    }
}
