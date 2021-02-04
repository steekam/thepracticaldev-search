<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SearchResults extends Component
{
    public array $sorting_options = ['most popular', 'most positive', 'newest', 'oldest'];

    public string $active_sort = 'most popular';

    public function getArticlesProperty(): Collection
    {
        return Article::with('user')->limit(5)->get();
    }

    public function render()
    {
        return view('livewire.search-results')->layout('components.layouts.app');
    }
}
