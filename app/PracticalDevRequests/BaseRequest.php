<?php

namespace App\PracticalDevRequests;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class BaseRequest
{
    protected static string $BASE_URL = "https://dev.to/api";

    protected static function request(): PendingRequest
    {
        return Http::withHeaders([
            'api-key' => config("practicaldev.api_key")
        ]);
    }

    protected static function endpoint(string $path): string
    {
        return self::$BASE_URL.$path;
    }
}
