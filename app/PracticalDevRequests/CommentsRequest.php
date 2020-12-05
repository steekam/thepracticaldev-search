<?php

namespace App\PracticalDevRequests;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;

class CommentsRequest extends BaseRequest
{
    public static function getArticleComments(int $article_id)
    {
        return self::request()
            ->get(self::endpoint('/comments'), ['a_id' => $article_id])
            ->throw()->json();
    }

    public static function getCommentsSentiment(Collection $comments)
    {
        $sentiment_api_url = config("practicaldev.sentiment_api_url");

        $body = $comments->map(function (Comment $comment) {
            return [
                'id' => $comment->id_code,
                'body_html' => $comment->body_html
            ];
        })
        ->all();

        return Http::post($sentiment_api_url."/classify", $body)->throw()->json();
    }
}
