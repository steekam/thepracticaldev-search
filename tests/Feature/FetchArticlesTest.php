<?php

use App\Jobs\FetchArticles;
use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use function Tests\mock_dev_api_requests;

uses(RefreshDatabase::class);

beforeEach(function () {
    mock_dev_api_requests();
});

it('can fetch articles from dev.to API', function () {
    Queue::fake();

    FetchArticles::dispatchNow(1, 1);

    Queue::assertPushed(function (FetchArticles $job) {
        return $job->get_current_page() == 2;

    });

    $this->assertCount(1, $articles = Article::with('comments')->get());

    $comments = $articles->first()->comments;

    $this->assertTrue($comments->isNotEmpty());

    $this->assertFalse(is_null($comments->first()->sentiment_score));
});

it('exits when articles endpoint returns nothing', function () {
    dispatch(
        (new FetchArticles(2, 1))->preventNextPageSpawn()
    );

    $this->assertCount(0, Article::all());
});
