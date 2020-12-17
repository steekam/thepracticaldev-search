<?php

use App\Jobs\FetchArticlesJob;
use app\models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use function Tests\mock_dev_api_requests;

uses(RefreshDatabase::class);

beforeEach(function () {
    mock_dev_api_requests();
});

it('can fetch articles from dev.to API', function () {
    Queue::fake();

    FetchArticlesJob::dispatchnow(1, 1);

    Queue::assertPushed(function (FetchArticlesJob $job) {
        return $job->get_current_page() == 2;
    });

    $this->assertSame(1, Article::count());
});

it('exits when articles endpoint returns nothing', function () {
    dispatch(
        (new FetchArticlesJob(2, 1))->preventnextpagespawn()
    );

    $this->assertCount(0, Article::all());
});
