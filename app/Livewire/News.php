<?php

namespace App\Livewire;

use App\Models\Image;
use App\Models\News as ModelsNews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\WithFileUploads;

class News extends Component
{
    use WithFileUploads;
    use WithPagination;

    // ========properties=======
    public $title, $slug, $images = [], $description, $status = 1, $user_id, $news_id = null;

    // ======validations======
    function rules()
    {
        // Check if it's an update operation
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|min:2|unique:news,slug,' . $this->news_id,
            'images' => isset($this->news_id) ? 'nullable|sometimes|array' : 'required|array',
            'images.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'status' => 'required',
            'user_id' => 'required'
        ];
    }


    // ===Runs once, immediately after the component is instantiated===
    public function mount()
    {
        $this->user_id = Auth::id();
    }


    // =====reset fields=======
    public function resetFields()
    {
        $this->title = '';
        $this->slug = '';
        $this->images = [];
        $this->description = '';
        $this->status = 1;
        // this will automatically remove the validation error msg
        $this->resetErrorBag();
        // reset news_id
        $this->news_id = null;
    }


    // =========load page===========
    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $news = ModelsNews::with('images', 'user')
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.news', [
            'news' => $news,
        ]);
    }

    // =========store===========
    public function store()
    {
        // check validation which automatically invoked the rules method
        $validatedData = $this->validate();
        try {

            // Store multiple images in  storage folder
            if ($this->images) {
                $imageNames = [];
                foreach ($this->images as  $image) {
                    $timestamp = now()->timestamp;
                    $originalName = $image->getClientOriginalName();
                    $imageName = $timestamp . '-' . $originalName;
                    $image->storeAs('public/images/news', $imageName);

                    // Store the image name in the array
                    $imageNames[] = $imageName;
                }
            }
            // Create the News entry
            $news = ModelsNews::create($validatedData);

            // Create Image entries associated with the News
            foreach ($imageNames as $imageName) {
                Image::create([
                    'images' => $imageName,
                    'news_id' => $news->id,
                ]);
            }
            /* 
            when the dispatch() method is called, the news-created 
            event will be dispatched, and every other component 
            on the page that is listening for this event will be notified
            */
            $this->dispatch('news-created', title: 'News created successfully!');

            // reset field after store data into db
            $this->resetFields();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }

    // ===========delete===============
    public function delete($id)
    {
        try {
            $news = ModelsNews::find($id);
            // delete image from local storage
            if (isset($news->images)) {
                foreach ($news->images as $key => $image) {
                    Storage::delete('public/images/news/' . $image->images);
                }
            }
            // delete from db
            $news->delete();
            $this->dispatch('news-deleted', title: 'News deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong!!");
        }
    }

    // =============update===========
    public function edit($id)
    {
        $this->news_id = $id;
        try {
            $news = ModelsNews::findOrFail($id);
            if (!$news) {
                $this->dispatch('error-message', title: 'Something went wrong!');
            } else {
                $this->title = $news->title;
                $this->slug = $news->slug;
                $this->description = $news->description;
                $this->status = $news->status;
            }
        } catch (\Throwable $th) {
            $this->dispatch('error-message', title: $th->getMessage());
        }
    }
    public function update()
    {
        // Check validation which automatically invokes the rules method
        $validatedData = $this->validate();

        try {
            if ($this->news_id) {
                $news = ModelsNews::with('images', 'user')->findOrFail($this->news_id);

                // Update news in the database
                $news->update($validatedData);

                // Check if new images are uploaded
                if (!empty($this->images)) {
                    // Delete all the old images from local storage folder & database
                    foreach ($news->images as $image) {
                        // Delete from local storage folder
                        Storage::delete('public/images/news/' . $image->images);
                        // Delete from the database
                        $image->delete();
                    }

                    // Store new images in the storage folder and database
                    foreach ($this->images as $image) {
                        $timestamp = now()->timestamp;
                        $originalName = $image->getClientOriginalName();
                        $imageName = $timestamp . '-' . $originalName;
                        $image->storeAs('public/images/news', $imageName);

                        // Save the image in the database
                        $news->images()->create([
                            'images' => $imageName,
                        ]);
                    }
                }

                /* 
                when the dispatch() method is called, the news-created 
                event will be dispatched, and every other component 
                on the page that is listening for this event will be notified
                */
                $this->dispatch('news-created', title: 'News updated successfully!');
                // reset field after store data into db
                $this->resetFields();
            }
        } catch (\Throwable $th) {
            $this->dispatch('error-message', title: $th->getMessage());
        }
    }
    // ==============================
}
