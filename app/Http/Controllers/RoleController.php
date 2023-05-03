<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    protected $user;
    protected $roles;
    protected $userid;
    public $tableName;

    public function __construct(Role $roles)
    {
        $this->roles = $roles;
        $this->tableName = 'roles';
        $this->middleware(function ($request, $next) {
            //    $this->user = Auth::user();
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         #permission verfy
         if (is_null($this->user) || !$this->user->can('role.view')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }
        // $all_roles_in_database = Role::all()->pluck('name');
        // $roles = $this->roles->all();
        $query = $this->roles->orderBy('created_at', 'desc');
        if ($request->search_status != null) {
            $query->where('status', $request->search_status);
        }
        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('guard_name', 'LIKE', '%' . $searchText . '%');
            });
        }
        $roles = $query->paginate(10);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         #permission verfy
         if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }
        $permissions = Permission::all();
        // $permission_groups = Permission::select('group_name')->groupBy('group_name')->get();
        $permission_groups = DB::table('permission_groups')->where('status',1)->get();
        return view('roles.create', [
            'permissions' => $permissions,
            'permission_groups' => $permission_groups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         #permission verfy
         if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }

        $validatedData = $request->validate(
            [
                'name' => 'required|regex:/^[a-zA-Z ]+$/u|min:3|max:20|unique:roles',
            ],
            [
                'name.required' => 'Role Name field is required.',
                'name.unique' => 'The role name has already been taken.',
                'name.regex' => 'The role name format is invalid. Please enter alpabatic text.',
                'name.min' => 'The role name must be at least 3 characters.',
                'name.max' => 'The role name may not be greater than 20 characters.'
            ]
        );
        $data = array(
            'name' => $request->name
        );

        $role = $this->roles->create($data);
        $permissions = $request->permissions;
        if(!empty($permissions)){
            for ($i = 0; $i < count($permissions); $i++) {
                $role->givePermissionTo($permissions[$i]);
            }
        }
        if ($role) {
            Webspice::log($this->tableName, $role->id, "Data Created.");
            Session::flash('success', 'Role Inserted Successfully.');
        } else {
            Session::flash('error', 'Role not inserted!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         #permission verfy
         if (is_null($this->user) || !$this->user->can('role.edit')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }
        $id = Crypt::decryptString($id);
        $roleInfo = $this->roles->findById($id);
       
        $permissions = Permission::all();
       // $permission_groups = Permission::select('group_name')->groupBy('group_name')->get();
       $permission_groups = DB::table('permission_groups')->where('status',1)->get();
        
        return view('roles.edit', [
            'roleInfo' => $roleInfo,
            'permissions' => $permissions,
            'permission_groups' => $permission_groups,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         #permission verfy
         if (is_null($this->user) || !$this->user->can('role.edit')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }
        $id = Crypt::decryptString($id);
        $validatedData = $request->validate(
            [
                'name' => 'required|regex:/^[a-zA-Z ]+$/u|min:3|max:20|unique:roles,name,' . $id
            ],
            [
                'name.required' => 'Role Name field is required.',
                'name.unique' =>  '"'.$request->name.'" The role name has already been taken.',
                'name.regex' => 'The role name format is invalid. Please enter alpabatic text.',
                'name.min' => 'The role name must be at least 3 characters.',
                'name.max' => 'The role name may not be greater than 20 characters.'
            ]
        );
        $role = $this->roles->findById($id);
        $permissions = $request->input('permissions');
        if(!empty($permissions)){
            $role->syncPermissions($permissions);
        }
        $role->name = $request->name; 
        $result = $role->save();
        if ($result) {
            #Log
            Webspice::log($this->tableName, $id, "Data Updated.");
            Session::flash('success', 'Role Updated Successfully.');
        } else {
            Session::flash('error', 'Role not Updated!');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         #permission verfy
         if (is_null($this->user) || !$this->user->can('role.delete')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }
        $id = Crypt::decryptString($id);
        $role = $this->roles->findById($id);
        if(!is_null($role)){
            $result = $role->delete();
        }
        if ($result) {
            # Log
            Webspice::log($this->tableName, $id, "Data Deleted.");
            Session::flash('success', 'Role deleted Successfully.');
        } else {
            Session::flash('error', 'Role not deleted!');
        }
        return back();
    }

    public function clearPermissionCache(){
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        Session::flash('success', 'Permission cache cleared Successfully.');
        return back();
    }
}
