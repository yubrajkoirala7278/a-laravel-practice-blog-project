<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BlogRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Blogs\Entities\Blog;

class BlogRepository implements BlogRepositoryInterface
{

    public function fetchService($request,$paginate=-1)
    {
        $query = Blog::with('user');
        if($request->has('action') && $request->action=="searchBlogs"){
            return $this->fetchBlogs($request,$query,$paginate);
        }
        $blogs = $query->latest()->get();
        return $blogs;
    }

    protected function fetchBlogs($request,$query,$paginate){
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }
        $blogs = $query->latest()->paginate($paginate);
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
        $request['user_id']=Auth::user()->id;
        $blog=Blog::create($request);
        return $blog;
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
        $request['user_id']=Auth::user()->id;
        // update in db
        $blog->update($request);
    }
}
