<?php

use App\Http\Livewire\SearchResults;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');
Route::get('search', SearchResults::class);
