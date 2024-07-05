<?php

namespace Modules\Blogs\Http\Controllers\admin;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:edit_users'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_users'])->only(['destroy']);
        $this->middleware(['permission:show_users'])->only(['index','show']);
        $this->middleware(['permission:create_users'])->only(['create','store']);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $users = User::latest();
                return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('role', function ($row) {
                        $role = $row->getRoleNames();
                        return '<span class="badge text-bg-success">' . $role[0] . '</span>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="javascript:void(0)" class="btn btn-info editButton" data-id="' . $row->id . '">Edit</a> 
                        <a href="javascript:void(0)" class="btn btn-danger delButton" data-id="' . $row->id . '">Delete</a> ';
                    })
                    ->rawColumns(['role', 'action'])
                    ->make(true);
            }
            $roles = Role::pluck('name', 'name')->all();
            return view('blogs::admin.users.index', compact('roles'));
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
        dd('this is create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(UserRequest $request)
    {
        try {
            // store single image in local storage folder
            if (isset($request['image'])) {
                $timestamp = now()->timestamp;
                $originalName = $request['image']->getClientOriginalName();
                $imageName = $timestamp . '-' . $originalName;

                $request['image']->storeAs('public/images/users', $imageName);
            };
            // store into db
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image' => $imageName
            ]);
            $user->syncRoles($request->role);
            return response()->json([
                'success' => 'User added successfully'
            ]);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
            // return response()->json(['error' =>'Something went wrong'],500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $user)
    {
        try {
            if (!$user) {
                abort(404);
            }
            return $user;
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
    public function update(UserRequest $request, User $user)
    {
        try {
            // Check if a new image is uploaded
            if (isset($request['image'])) {
                // Delete the old image from storage folder
                Storage::delete('public/images/users/' . $user->image);
                // Store the new image
                $timestamp = now()->timestamp;
                $originalName = $request['image']->getClientOriginalName();
                $imageName = $timestamp . '-' . $originalName;
                $request['image']->storeAs('public/images/users', $imageName);
                // Update the image name in the $request array
                $request['image'] = $imageName;
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'image' => $imageName
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            }
            if (!$user) {
                abort(404);
            }
            return response()->json([
                'success' => 'User Updated Successfully'
            ], 201);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(User $user)
    {
        try {
            if (!$user) {
                abort(404);
            }
            Storage::delete('public/images/users/' . $user->image);
            $user->delete();
            return response()->json([
                'success' => 'user Deleted Successfully'
            ], 201);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
