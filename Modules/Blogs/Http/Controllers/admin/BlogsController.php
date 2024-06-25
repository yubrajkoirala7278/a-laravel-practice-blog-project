<?php

namespace Modules\Blogs\Http\Controllers\admin;

use App\Events\BlogCreated;
use App\Events\TestNotification;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blogs\Entities\Blog;
use Modules\Blogs\Http\Requests\BlogRequest;
use Yajra\DataTables\Facades\DataTables;

class BlogsController extends Controller
{
    private $blogRepository;
    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $blogs = $this->blogRepository->fetchService($request);
                return DataTables::of($blogs)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $viewUrl = route('admin.blogs.show', ['slug' => $row->slug]);
                        $editUrl = route('admin.blogs.edit', ['slug' => $row->slug]);
                        return '<a href="' . $editUrl . '" class="btn btn-info editButton" >Edit</a> 
                        <a href="javascript:void(0)" class="btn btn-danger delButton" data-slug="' . $row->slug . '">Delete</a> 
                        <a href="' . $viewUrl . '" class="btn btn-success">View</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('blogs::admin.blogs.index');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('blogs::admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(BlogRequest $request)
    {
        try {
            $dataToStore = $request->only('title', 'slug', 'description', 'image', 'is_published');
            $blog = $this->blogRepository->store($dataToStore);
            $data = ['subject'=>'Blog has been added','title' => $blog['title'], 'author' => auth()->user()->name, 'email' => auth()->user()->email];
            event(new BlogCreated($data));
            return redirect()->route('admin.blog')->with('success', 'Blog added successfully');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($slug)
    {
        try {
            $blog = $this->blogRepository->show($slug);
            return view('blogs::admin.blogs.show', compact('blog'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($slug)
    {
        try {
            $blog = $this->blogRepository->show($slug);
            return view('blogs::admin.blogs.edit', compact('blog'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        try {
            $dataToStore = $request->only('title', 'slug', 'description', 'image', 'is_published');
            $this->blogRepository->updateService($dataToStore, $blog);
            return redirect()->route('admin.blog')->with('success', 'Blog updated successfully');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Blog $blog)
    {
        try {
            $this->blogRepository->destroy($blog);
            return response()->json([
                'success' => 'Blog Deleted Successfully'
            ], 201);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
