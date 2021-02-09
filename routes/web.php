<?php

use App\Http\Livewire\DemoPage;
use App\Http\Livewire\SearchResults;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');
Route::get('search', SearchResults::class);
Route::get('demo', DemoPage::class);
