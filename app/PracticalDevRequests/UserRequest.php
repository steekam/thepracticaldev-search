<?php

namespace App\PracticalDevRequests;

class UserRequest extends BaseRequest
{
    public static function getByUsername(string $username)
    {
        return self::request()
            ->get(self::endpoint('/users/by_username'), [
                'url' => $username
            ])->throw()
            ->json();
    }
}
