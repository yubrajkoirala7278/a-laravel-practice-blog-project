<?php

namespace App\Livewire;

use App\Models\News;
use Livewire\Component;

class NewsView extends Component
{
    public $newsItem;

    public function mount($id)
    {
        $this->newsItem = News::findOrFail($id); 
    }

    public function render()
    {
        return view('livewire.news-view');
    }
}
