<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class DemoPage extends Component
{
    public function render()
    {
        $highly_positive_comments = Comment::classified()->orderBy('sentiment_score', 'desc')->limit(5)->get();
        $highly_negative_comments = Comment::classified()->orderBy('sentiment_score', 'asc')->limit(5)->get();

        return view('livewire.demo-page', compact('highly_negative_comments', 'highly_positive_comments'))
            ->layout('components.layouts.base');
    }
}
