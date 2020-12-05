<?php

namespace Tests;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function mock_dev_api_requests(): void
{
    $mocks_content = collect(Storage::disk('mocks')->files())
    ->flatMap(fn ($file) => [(string) Str::of($file)->basename('.json') => json_decode(Storage::disk('mocks')->get($file), true)]);

    Http::fake([
        'https://dev.to/api/articles?top=1095&per_page=1&page=1' => Http::response($mocks_content->get('all_articles'), 200),
        'https://dev.to/api/articles?top=1095&per_page=1&page=2' => Http::response([], 200),
        'https://dev.to/api/articles/185402' => Http::response($mocks_content->get('article_185402'), 200),
        'https://dev.to/api/comments?a_id=185402' => Http::response($mocks_content->get('article_185402_comments'), 200),
        'https://dev.to/api/users/by_username?url=simonholdorf' => Http::response($mocks_content->get('user_simonholdorf'), 200),
    ]);
}
