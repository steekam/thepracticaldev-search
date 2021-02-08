<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class SearchResults extends Component
{
    public string $query = '';

    protected $queryString = [
        'query' => ['except' => ''],
    ];

    public $articles;

    public bool $ready_to_show = false;

    protected $listeners = ['queryUpdated' => 'updateSearchString'];

    public array $sorting_options = ['most relevant', 'most popular', 'most positive'];

    public string $active_sort = 'most relevant';

    public function mount()
    {
        $this->articles = collect();
    }

    public function loadArticles()
    {
        $this->articles = $this->fetchArticles();
        $this->ready_to_show = true;
    }

    public function fetchArticles()
    {
        $articles_query = empty($this->query) ? Article::limit(20) : Article::search($this->query);

        if ($this->active_sort === 'most relevant' || $this->active_sort === 'most popular' ) {
            $articles_query->orderBy('positive_reactions_count', 'desc');
        }

        if ($this->active_sort === 'most positive') {
            // TODO: add dynamic polarity score value
        }

        // TODO: abstract the counts to model
        $articles =  tap(
            $articles_query->get(),
            fn ($articles) => $articles->load('user')
            ->loadCount([
                'comments' => fn($query) => $query->whereNotNull('sentiment_score'), //TODO: temporary until classification job ends
                'comments as positive_comments_count' => function ($query) {
                    $query->where('sentiment_score', '>=', 0.5);
                },
                'comments as negative_comments_count' => function ($query) {
                    $query->where('sentiment_score', '<', 0.5);
                },
            ])
        );

        if (!empty($this->query)) {
           Cache::put('retrieved_articles_in_relevance_order', $articles);
        }

        return $articles;
    }

    public function updatedActiveSort($value)
    {
        if (empty($this->query)) {
            $this->articles = $this->fetchArticles()->load('user');
            return;
        }

        if ($this->active_sort === 'most relevant') {
            $this->articles = Cache::get('retrieved_articles_in_relevance_order');
        }

        if ($this->active_sort === 'most popular') {
            $this->articles = $this->articles->sortByDesc('positive_reactions_count');
        }

        $this->articles->load('user');
    }

    public function search()
    {
        $this->articles = $this->fetchArticles();
    }

    public function render()
    {
        return view('livewire.search-results')->layout('components.layouts.base');
    }
}
