<?php

namespace App\Http\Controllers;

use Exception;
use App\Lib\Webspice;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermissionExport;

class PermissionController extends Controller
{
    protected $webspice;
    protected $user;
    protected $permissions;
    protected $userid;
    public $tableName;

    public function __construct(Permission $permissions)
    {
        $this->webspice = new Webspice();
        $this->permissions = $permissions;
        $this->tableName = 'permissions';
        $this->middleware(function ($request, $next) {
            //    $this->user = Auth::user();
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('permission.view');

        $fileTag = '';
        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->permissions->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->permissions->orderBy('created_at', 'desc');
        }

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
        if ($request->submit_btn == 'export') {
            $title = $fileTag . 'Permission List';
            $fileName = str_replace(' ', '_', strtolower($title));
            return Excel::download(new PermissionExport($query->get(), $title), $fileName . '_' . time() . '.xlsx');
        }

        $permissions = $query->paginate(8);
        return view('permission.index', compact('permissions'));
    }


    public function create()
    {
        #permission verfy
        $this->webspice->permissionVerify('permission.create');

        $permissions = Permission::all();
        $permission_groups = DB::table('permission_groups')->where('status', 1)->get();
        return view('permission.create', [
            'permission_groups' => $permission_groups,
        ]);
    }


    public function store(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('permission.create');

        if ($request->is_menu == 'yes') {

            $request->validate(
                [
                    'group_name' => 'required',
                    'menu_name' => 'required',
                    // 'icon' => 'required',
                    'name' => 'required|regex:/^[a-zA-Z._-]+$/u|min:3|max:50|unique:permissions',
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
        } else {

            $request->validate(
                [
                    'group_name' => 'required',
                    'name' => 'required|regex:/^[a-zA-Z._-]+$/u|min:3|max:50|unique:permissions',
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
        try {
            $this->permissions->create($data);
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
        $this->webspice->permissionVerify('permission.edit');
        $id = $this->webspice->encryptDecrypt('decrypt', $id);
        $permissionInfo = $this->permissions->findById($id);

        $permission_groups = DB::table('permission_groups')->where('status', 1)->get();

        return view('permission.edit', [
            'permissionInfo' => $permissionInfo,
            'permission_groups' => $permission_groups,
        ]);
    }


    public function update(Request $request, $id)
    {
        #permission verfy
        $this->webspice->permissionVerify('permission.edit');

        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        if ($request->is_menu == 'yes') {

            $request->validate(
                [
                    'group_name' => 'required',
                    'menu_name' => 'required',
                    // 'icon' => 'required',
                    'name' => 'required|regex:/^[a-zA-Z._-]+$/u|min:3|max:50|unique:permissions,name,' . $id
                ],
                [
                    'menu_name.required' => 'Menu Name field is required.',
                    'icon.required' => 'Meue Icon field is required.',
                    'group_name.required' => 'Group Name field is required.',
                    'name.required' => 'Permission name field is required.',
                    'name.unique' =>  '"' . $request->name . '" The permission name has already been taken.',
                    'name.regex' => 'The permission name format is invalid. Please enter alpabatic text.',
                    'name.min' => 'The permission name must be at least 3 characters.',
                    'name.max' => 'The permission name may not be greater than 50 characters.'
                ]
            );
        } else {

            $request->validate(
                [
                    'group_name' => 'required',
                    'name' => 'required|regex:/^[a-zA-Z.-_]+$/u|min:3|max:50|unique:permissions,name,' . $id
                ],
                [
                    'group_name.required' => 'Group Name field is required.',
                    'name.required' => 'Permission name field is required.',
                    'name.unique' => '"' . $request->name . '", The permission name has already been taken.',
                    'name.regex' => 'The permission name format is invalid. Please enter alpabatic text.',
                    'name.min' => 'The permission name must be at least 3 characters.',
                    'name.max' => 'The permission name may not be greater than 50 characters.'
                ]
            );
        }
        try {
            $permission = $this->permissions->findById($id);
            $permission->group_name = $request->group_name;
            $permission->name = $request->name;
            $permission->is_menu = $request->is_menu;
            $permission->menu_name = $request->menu_name;
            $permission->icon = $request->icon;
            $permission->save();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }


    public function destroy($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('permission.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $permission = $this->permissions->findById($id);
            $permission->delete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return back();
    }

    public function forceDelete($id)
    {
        return response()->json(['error' => 'Unauthenticated.'], 401);
        #permission verfy
        $this->webspice->permissionVerify('permission.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $permission = Permission::withTrashed()->findOrFail($id);
            $permission->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('permission.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $permission = Permission::withTrashed()->findOrFail($id);
            $permission->restore();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
       return redirect()->route('permissions.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('permission.restore');
        try {
            $permissions = Permission::onlyTrashed()->get();
            foreach ($permissions as $permission) {
                $permission->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('permissions.index');
    }

    public function clearPermissionCache()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        Session::flash('success', 'Permission cache cleared Successfully.');
        return back();
    }
}
