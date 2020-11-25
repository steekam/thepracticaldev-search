<?php

namespace App\PracticalDevRequests;

use Illuminate\Http\Client\Response;

class UserRequest extends BaseRequest
{
    public static function getByUsername(string $username): Response
    {
        return self::request()
            ->get(self::endpoint("/users/by_username"), [
                "url" => $username
            ]);
    }
}
