<?php

namespace App\Livewire;

use App\Models\News;
use Livewire\WithPagination;
use Livewire\Component;

class NewsList extends Component
{
    use WithPagination;

    public function render()
    {
        $news = News::latest()->paginate(10); // Adjust pagination as needed

        return view('livewire.news-list', [
            'news' => $news,
        ]);
    }
}
