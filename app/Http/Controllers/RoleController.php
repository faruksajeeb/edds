<?php

namespace App\Http\Controllers;

use Exception;
use App\Lib\Webspice;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RoleExport;


class RoleController extends Controller
{
    protected $webspice;
    protected $role;
    protected $roles;
    protected $roleid;
    public $tableName;

    public function __construct(Role $roles)
    {
        $this->webspice = new Webspice();
        $this->roles = $roles;
        $this->tableName = 'roles';
        $this->middleware(function ($request, $next) {
            //    $this->user = Auth::user();
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('role.view');

        $fileTag = '';
        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->roles->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->roles->orderBy('created_at', 'desc');
        }

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
        if ($request->submit_btn == 'export') {
            $title = $fileTag . 'Role List';
            $fileName = str_replace(' ', '_', strtolower($title));
            return Excel::download(new RoleExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $roles = $query->paginate(10);
        return view('role.index', compact('roles'));
    }


    public function create()
    {
        #permission verfy
        $this->webspice->permissionVerify('role.create');

        $permissions = Permission::all();
        // $permission_groups = Permission::select('group_name')->groupBy('group_name')->get();
        $permission_groups = DB::table('permission_groups')->where('status', 1)->get();
        return view('role.create', [
            'permissions' => $permissions,
            'permission_groups' => $permission_groups,
        ]);
    }


    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('role.create');

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
        try {
            $role = $this->roles->create($data);
            $permissions = $request->permissions;
            if (!empty($permissions)) {
                for ($i = 0; $i < count($permissions); $i++) {
                    $role->givePermissionTo($permissions[$i]);
                }
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }

        return redirect()->back();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('role.edit');
        try {
            # decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);

            $roleInfo = $this->roles->findById($id);

            $permissions = Permission::all();
            // $permission_groups = Permission::select('group_name')->groupBy('group_name')->get();
            $permission_groups = DB::table('permission_groups')->where('status', 1)->get();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return view('role.edit', [
            'roleInfo' => $roleInfo,
            'permissions' => $permissions,
            'permission_groups' => $permission_groups,
        ]);
    }


    public function update(Request $request, $id)
    {
        #permission verfy
        $this->webspice->permissionVerify('role.edit');
        try {
            # decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);

            $request->validate(
                [
                    'name' => 'required|regex:/^[a-zA-Z ]+$/u|min:3|max:20|unique:roles,name,' . $id
                ],
                [
                    'name.required' => 'Role Name field is required.',
                    'name.unique' =>  '"' . $request->name . '" The role name has already been taken.',
                    'name.regex' => 'The role name format is invalid. Please enter alpabatic text.',
                    'name.min' => 'The role name must be at least 3 characters.',
                    'name.max' => 'The role name may not be greater than 20 characters.'
                ]
            );

            $role = $this->roles->findById($id);
            $permissions = $request->input('permissions');
            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }
            $role->name = $request->name;
            $role->save();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('roles.index');
    }


    public function destroy($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('role.delete');
        try {
            # decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);

            $role = $this->roles->findById($id);            
            $role->delete();
            
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return back();
    }


    public function forceDelete($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('role.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $role = Role::withTrashed()->findOrFail($id);
            $role->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('role.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $role = Role::withTrashed()->findOrFail($id);
            $role->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        // return redirect()->route('roles.index', ['status' => 'archived'])->withSuccess(__('User restored successfully.'));
        return redirect()->route('roles.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('role.restore');
        try {
            $roles = Role::onlyTrashed()->get();
            foreach ($roles as $role) {
                $role->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('roles.index');
        // return redirect()->route('roles.index')->withSuccess(__('All roles restored successfully.'));
    }

    public function clearPermissionCache()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        Session::flash('success', 'Permission cache cleared Successfully.');
        return back();
    }
}
