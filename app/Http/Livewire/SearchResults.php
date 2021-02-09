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

    public array $sorting_options = ['most relevant', 'most popular', 'most positive', 'newest', 'oldest'];

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
        if(empty($this->query)) {
            return  Article::limit(20)
                            ->orderBy('positive_reactions_count', 'desc')
                            ->get()
                            ->load('user')
                            ->loadCommentCounts();
        }

        $articles = Article::search($this->query)
                            ->get()
                            ->load('user')
                            ->loadCommentCounts()
                            ->loadSum('comments', 'sentiment_score');

        if ($articles->isEmpty()) {
            return $articles;
        }

        if ($this->active_sort == 'most relevant') {
            Cache::put('retrieved_articles_in_relevance_order', $articles);
            return $articles;
        }

        return $articles->sortBasedOn($this->active_sort);
    }

    public function updatedActiveSort($value)
    {
        if (empty($this->query)) {
            $this->articles = $this->fetchArticles();
            return;
        }

        $this->articles->load('user')
        ->loadCommentCounts()
        ->loadSum('comments', 'sentiment_score');

        $this->articles = $this->articles->sortBasedOn($this->active_sort);
    }

    public function searchArticles()
    {
        $this->articles = $this->fetchArticles();
    }

    public function render()
    {
        return view('livewire.search-results')->layout('components.layouts.base');
    }
}
