<?php

namespace App\Models;

use App\PracticalDevRequests\UserRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

        $user = new User(
            collect(UserRequest::getByUsername($username))
            ->only('id', 'username', 'name', 'profile_image')
            ->all()
        );

        $user->save();

        return $user;
    }
}
