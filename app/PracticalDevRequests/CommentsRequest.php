<?php

namespace App\PracticalDevRequests;

use Illuminate\Http\Client\Response;

class CommentsRequest extends BaseRequest
{
    public static function getArticleComments(int $article_id): Response
    {
        return self::request()
            ->get(self::endpoint("/comments"), ["a_id" => $article_id]);
    }
}
