<?php

namespace Modules\Blogs\Http\Controllers\admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if($request->ajax()){
                $users = User::latest();
                return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return '<a href="javascript:void(0)" class="btn btn-info editButton" data-id="' . $row->id . '">Edit</a> 
                        <a href="javascript:void(0)" class="btn btn-danger delButton" data-id="' . $row->id . '">Delete</a> ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('blogs::admin.users.index');
           
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
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
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
    public function update(UserRequest $request,User $user)
    {
        try {
           $user->update($request->validated());
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
        try{
            if (!$user) {
                abort(404);
            }
            $user->delete();
            return response()->json([
                'success' => 'user Deleted Successfully'
            ], 201);
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}
