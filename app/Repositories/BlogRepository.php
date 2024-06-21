<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BlogRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Modules\Blogs\Entities\Blog;

class BlogRepository implements BlogRepositoryInterface
{

    public function fetchService($request,$paginate=-1)
    {
        $query = Blog::query();
        if($paginate!=-1){
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            }

            $blogs = $query->latest()->paginate(5);
            return $blogs;
        }
        $blogs = $query->latest()->get();
        return $blogs;
    }

    public function store($request)
    {
        // store single image in local storage folder
        if (isset($request['image'])) {
            $timestamp = now()->timestamp;
            $originalName = $request['image']->getClientOriginalName();
            $imageName = $timestamp . '-' . $originalName;
            $request['image']->storeAs('public/images/blogs', $imageName);

            // update the image name in the $request array
            $request['image'] = $imageName;
        };
        Blog::create($request);
    }

    public function destroy($blog)
    {
        if (isset($blog['image'])) {
            Storage::delete('public/images/blogs/' . $blog['image']);
        }
        $blog->delete();
    }

    public function show($slug)
    {
        $blog=Blog::where('slug',$slug)->first();
       return $blog;
    }

    public function updateService($request, $blog){
        // Check if a new image is uploaded
        if(isset($request['image'])){
            // Delete the old image from storage folder
            Storage::delete('public/images/blogs/'.$blog->image);
            // Store the new image
            $timestamp = now()->timestamp;
            $originalName = $request['image']->getClientOriginalName();
            $imageName = $timestamp . '-' . $originalName;
            $request['image']->storeAs('public/images/blogs', $imageName);
            // Update the image name in the $request array
            $request['image'] = $imageName;
        } 
        // update in db
        $blog->update($request);
    }
}
