<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NavbarSearchInput extends Component
{
    public string $query = '';

    protected $queryString = [
        'query' => ['except' => ''],
    ];

    public function render()
    {
        return view('livewire.navbar-search-input');
    }
}
