<?php

namespace App\Models;

use App\PracticalDevRequests\ArticleRequest;
use App\PracticalDevRequests\CommentsRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'slug',
        'path',
        'url',
        'canonical_url',
        'comments_count',
        'public_reactions_count',
        'positive_reactions_count',
        'tags',
        'published_timestamp',
        'user_id',
        'body_html'
    ];

    public $timestamps = false;

    public $incrementing = false;

    protected $dates = ['published_timestamp'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public static function create_from_response(Collection $article_details): Article
    {
        $article_id = $article_details['id'];

        $article_properties = $article_details
        ->merge([
            'user_id' => User::get_by_username($article_details['user']['username'])->id,
            'body_html' => ArticleRequest::getSingleArticle($article_id)['body_html'],
        ])
        ->all();

        return self::firstOrCreate(
            ['id' => $article_id],
            $article_properties
        );
    }

    public function classify_comments(): void
    {
        $comments = $this->comments()->whereNull("sentiment_score")->get();

        if ($comments->isEmpty()) return;

        collect(CommentsRequest::getCommentsSentiment($comments))
        ->each(function (array $response) {
            Comment::where('id_code', $response['id'])
            ->update(['sentiment_score' => $response['sentiment_score']]);
        });
    }
}
