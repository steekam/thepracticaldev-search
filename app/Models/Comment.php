<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_code',
        'body_html',
        'article_id',
        'user_id',
        'parent_id_code',
        'sentiment_score',
        'created_at'
    ];

    public $timestamps = false;

    public $incrementing = false;

    protected $dates = ['created_at'];

    public static function create_from_details(Collection $comment_details): Comment
    {
        $comment = self::firstOrCreate(
            ['id_code' => $comment_details->get('id_code')],
            $comment_details->put('user_id', User::get_by_username($comment_details->get('user')['username'])->id)
            ->all()
        );

        collect($comment_details->get('children'))
        ->whenNotEmpty(function (Collection $children_collection) use ($comment) {
            $children_collection->mapInto(Collection::class)
            ->filter(fn (Collection $child_comment_details) => ! empty($child_comment_details->get('user')))
            ->each(function (Collection $child_comment_details) use ($comment) {
                Comment::create_from_details($child_comment_details->merge([
                    'article_id' => $comment->article_id,
                    'parent_id_code' => $comment->id_code
                ]));
            });
        });

        return $comment;
    }

    public function article()
    {
        return $this->belongsTo(Artcle::class);
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id_code', 'id_code');
    }

    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_id_code', 'id_code');
    }

    public function scopeUnclassified(Builder $query): Builder
    {
        return $query->whereNull('sentiment_score');
    }

    public static function update_sentiment_from_api_response(array $response): void
    {
        static::where('id_code', $response['id'])
        ->update(['sentiment_score' => $response['sentiment_score']]);
    }
}
