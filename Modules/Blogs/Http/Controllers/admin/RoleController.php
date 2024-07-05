<?php

namespace Modules\Blogs\Http\Controllers\admin;

use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:edit_roles'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_roles'])->only(['destroy']);
        $this->middleware(['permission:show_roles'])->only(['index','show']);
        $this->middleware(['permission:create_roles'])->only(['create','store']);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $roles = Role::latest()->get();
            return view('blogs::admin.roles.index', compact('roles'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function addPermissionToRole($roleId)
    {
        try {
            $permissions = Permission::latest()->get();
            $role = Role::findOrFail($roleId);
            $rolePermissions = DB::table('role_has_permissions')
                ->where('role_has_permissions.role_id', $role->id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
            return view('blogs::admin.roles.add-permissions', compact('permissions', 'role', 'rolePermissions'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        try {
            $role = Role::findOrFail($roleId);
            $role->syncPermissions($request->permission);
            return redirect()->route('roles.index')->with('success', 'Permission added to role');
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
        return view('blogs::admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(RoleRequest $request)
    {
        try{
            Role::create($request->validated());
            return redirect()->route('roles.index')->with('success','Role added successfully!');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('blogs::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('blogs::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
