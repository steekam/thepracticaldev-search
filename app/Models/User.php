<?php

namespace App\Models;

use App\PracticalDevRequests\UserRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\RequestException;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'username',
        'name',
        'profile_image'
    ];

    public $timestamps = false;

    public $incrementing = false;

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public static function get_by_username(string $username)
    {
        if ($user = User::where('username', $username)->first()) {
            return $user;
        }

        try {
            $fetched_user = collect(UserRequest::getByUsername($username));

            return static::updateOrCreate(
                ['id' => $fetched_user['id']],
                $fetched_user->only('username', 'name', 'profile_image')->all(),
            );
        } catch (RequestException $exception) {
            // ? Skip comments with missing users
            if ($exception->response->status() == 404) {
                return false;
            }

            throw $exception;
        }
    }
}
