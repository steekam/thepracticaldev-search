<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SearchResults extends Component
{
    public string $query = '';

    protected $queryString = [
        'query' => ['except' => ''],
    ];

    public $articles;

    protected $listeners = ['queryUpdated' => 'updateSearchString'];

    public array $sorting_options = ['most popular', 'most positive', 'newest', 'oldest'];

    public string $active_sort = 'most popular';

    public function mount()
    {
        $this->fetchArticles();
    }

    public function fetchArticles()
    {
        $articles_query = empty($this->query) ? Article::limit(20) : Article::search($this->query);

        if($this->active_sort === 'most popular') {
            $articles_query->orderBy('positive_reactions_count', 'desc');
        }

        if($this->active_sort === 'newest') {
            $articles_query->orderBy('published_timestamp', 'desc');
        }

        if($this->active_sort === 'oldest') {
            $articles_query->orderBy('published_timestamp', 'asc');
        }

        $this->articles = tap($articles_query->get(), fn($articles) => $articles->load('user')->loadCount('comments'));
    }

    public function updatedActiveSort($value)
    {
        if (empty($this->query)) {
            $this->fetchArticles();
        }

        if($this->active_sort === 'most popular') {
            $this->articles = $this->articles->sortByDesc('positive_reactions_count');
        }

        if($this->active_sort === 'newest') {
            $this->articles = $this->articles->sortByDesc('published_timestamp');
        }

        if($this->active_sort === 'oldest') {
            $this->articles = $this->articles->sortBy('published_timestamp');
        }
    }

    public function updateSearchString(string $new_query)
    {
        $this->query = $new_query;
        $this->fetchArticles();
    }

    public function updatedQuery($value)
    {
        $this->fetchArticles();
    }

    public function render()
    {
        return view('livewire.search-results')->layout('components.layouts.app');
    }
}
