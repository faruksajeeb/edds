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

class PermissionController extends Controller
{
    protected $user;
    protected $permissions;
    protected $userid;
    public $tableName;

    public function __construct(Permission $permissions)
    {
        $this->permissions = $permissions;
        $this->tableName = 'permissions';
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
         if (is_null($this->user) || !$this->user->can('permission.view')) {
            abort(403, 'SORRY! You are unauthorized to access permission list!');
        }
        // $all_roles_in_database = Role::all()->pluck('name');
        // $roles = $this->roles->all();
        $query = $this->permissions->orderBy('id', 'asc');
        if ($request->search_status != null) {
            $query->where('status', $request->search_status);
        }
        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('group_name', 'LIKE', '%' . $searchText . '%');
            });
        }
        $permissions = $query->paginate(8);
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         #permission verfy
         if (is_null($this->user) || !$this->user->can('permission.create')) {
            abort(403, 'SORRY! You are unauthorized to create permission!');
        }
        $permissions = Permission::all();
        $permission_groups = DB::table('permission_groups')->where('status',1)->get();
        return view('permissions.create', [
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
         if (is_null($this->user) || !$this->user->can('permission.create')) {
            abort(403, 'SORRY! You are unauthorized to create permission!');
        }
        if($request->is_menu=='yes'){

            $request->validate(
                [
                    'group_name' => 'required',
                    'menu_name' => 'required',
                    // 'icon' => 'required',
                    'name' => 'required|regex:/^[a-zA-Z._ ]+$/u|min:3|max:50|unique:permissions',
                ],
                [
                    'menu_name.required' => 'Menu Name field is required.',
                    'icon.required' => 'Meue Icon field is required.',
                    'group_name.required' => 'Group Name field is required.',
                    'name.required' => 'Permission name field is required.',
                    'name.unique' => 'The permission name has already been taken.',
                    'name.regex' => 'The permission name format is invalid. Please enter alpabatic text.',
                    'name.min' => 'The permission name must be at least 3 characters.',
                    'name.max' => 'The permission name may not be greater than 50 characters.'
                ]
            );
        }else{

            $request->validate(
                [
                    'group_name' => 'required',
                    'name' => 'required|regex:/^[a-zA-Z. ]+$/u|min:3|max:50|unique:permissions',
                ],
                [
                    'group_name.required' => 'Group Name field is required.',
                    'name.required' => 'Permission name field is required.',
                    'name.unique' => 'The permission name has already been taken.',
                    'name.regex' => 'The permission name format is invalid. Please enter alpabatic text.',
                    'name.min' => 'The permission name must be at least 3 characters.',
                    'name.max' => 'The permission name may not be greater than 50 characters.'
                ]
            );
        }

        $data = array(
            'guard_name' => 'web',
            'group_name' => $request->group_name,
            'name' => $request->name,
            'is_menu' => $request->is_menu,
            'menu_name' => $request->menu_name,
            'icon' => $request->icon,
        );
        $permission = $this->permissions->create($data);
    
        if ($permission) {
            Webspice::log($this->tableName, $permission->id, "Data Created.");
            Session::flash('success', 'Permission Created Successfully.');
        } else {
            Session::flash('error', 'Permission not created!');
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
         if (is_null($this->user) || !$this->user->can('permission.edit')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }
        $id = Crypt::decryptString($id);
        $permissionInfo = $this->permissions->findById($id);
      
        $permission_groups = DB::table('permission_groups')->where('status',1)->get();
        
        return view('permissions.edit', [
            'permissionInfo' => $permissionInfo,
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
         if (is_null($this->user) || !$this->user->can('permission.edit')) {
            abort(403, 'SORRY! You are unauthorized to update permission!');
        }
        $id = Crypt::decryptString($id);    

        if($request->is_menu=='yes'){

            $request->validate(
                [
                    'group_name' => 'required',
                    'menu_name' => 'required',
                    // 'icon' => 'required',
                    'name' => 'required|regex:/^[a-zA-Z. ]+$/u|min:3|max:50|unique:permissions,name,' . $id
                ],
                [
                    'menu_name.required' => 'Menu Name field is required.',
                    'icon.required' => 'Meue Icon field is required.',
                    'group_name.required' => 'Group Name field is required.',
                    'name.required' => 'Permission name field is required.',
                    'name.unique' =>  '"'.$request->name.'" The permission name has already been taken.',
                    'name.regex' => 'The permission name format is invalid. Please enter alpabatic text.',
                    'name.min' => 'The permission name must be at least 3 characters.',
                    'name.max' => 'The permission name may not be greater than 50 characters.'
                ]
            );
        }else{

            $request->validate(
                [
                    'group_name' => 'required',
                    'name' => 'required|regex:/^[a-zA-Z. ]+$/u|min:3|max:50|unique:permissions,name,' . $id
                ],
                [
                    'group_name.required' => 'Group Name field is required.',
                    'name.required' => 'Permission name field is required.',
                    'name.unique' => '"'.$request->name.'", The permission name has already been taken.',
                    'name.regex' => 'The permission name format is invalid. Please enter alpabatic text.',
                    'name.min' => 'The permission name must be at least 3 characters.',
                    'name.max' => 'The permission name may not be greater than 50 characters.'
                ]
            );
        }
        $permission = $this->permissions->findById($id);
       
        $permission->group_name = $request->group_name; 
        $permission->name = $request->name; 
        $permission->is_menu = $request->is_menu; 
        $permission->menu_name = $request->menu_name; 
        $permission->icon = $request->icon; 
        $result = $permission->save();
        if ($result) {
            #Log
            Webspice::log($this->tableName, $id, "Data Updated.");
            Session::flash('success', 'Permission Updated Successfully.');
        } else {
            Session::flash('error', 'Permission not Updated!');
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
         if (is_null($this->user) || !$this->user->can('permission.delete')) {
            abort(403, 'SORRY! You are unauthorized to delete permission!');
        }
        $id = Crypt::decryptString($id);
        $permission = $this->permissions->findById($id);
        if(!is_null($permission)){
            $result = $permission->delete();
        }
        if ($result) {
            # Log
            Webspice::log($this->tableName, $id, "Data Deleted.");
            Session::flash('success', 'Permission deleted successfully.');
        } else {
            Session::flash('error', 'Permission not deleted!');
        }
        return back();
    }

    public function clearPermissionCache(){
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        Session::flash('success', 'Permission cache cleared Successfully.');
        return back();
    }
}
