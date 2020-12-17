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
        $article = self::find($article_details['id']);

        if (! $article) {
            $properties = $article_details->merge([
                'user_id' => User::get_by_username($article_details['user']['username'])->id,
                'body_html' => ArticleRequest::getSingleArticle($article_details['id'])['body_html'],
            ])->all();

            $article = self::create($properties);
        }

        return $article;
    }

    public function classify_comments(): void
    {
        $comments = $this->comments()->unclassified()->get();

        if ($comments->isEmpty()) {
            return;
        }

        collect(CommentsRequest::getCommentsSentiment($comments))
        ->each(fn (array $response) => Comment::update_sentiment_from_api_response($response));
    }
}
