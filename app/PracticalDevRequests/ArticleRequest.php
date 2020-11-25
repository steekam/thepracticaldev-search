<?php

namespace App\PracticalDevRequests;

use Illuminate\Http\Client\Response;

class ArticleRequest extends BaseRequest
{
    public static function getAllArticles(int $current_page, int $results_per_page = 500): Response
    {
        return self::request()
            ->get(self::endpoint("/articles"), [
                "top" => 1095, // last 3 years
                "per_page" => $results_per_page,
                "page" => $current_page,
            ]);
    }

    public static function getSingleArticle(int $article_id): Response
    {
        return self::request()
            ->get(self::endpoint("/articles/" . $article_id));
    }
}
