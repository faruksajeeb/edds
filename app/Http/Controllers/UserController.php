<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * The user repository instance.
     */
    public $user;
    public $tableName;
    protected $users;

    public function __construct(User $users)
    {
        $this->tableName = 'users';
        $this->middleware(function ($request, $next) {
            //    $this->user = Auth::user();
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
        $this->users = $users;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        #permission verfy
        if (is_null($this->user) || !$this->user->can('user.view')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }

        # Query Start
        $query = $this->users->orderBy('created_at', 'desc');
        if ($request->search_status != null) {
            $query->where('status', $request->search_status);
        }
        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchText . '%');
            });
        }
        $users = $query->paginate(10);
        #Query End
        return view('users.index', compact('users'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        #permission verfy
        if (is_null($this->user) || !$this->user->can('user.create')) {
            abort(403, 'SORRY! You are unauthorized to create user!');
        }

        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = Permission::select('group_name')->groupBy('group_name')->get();

        return view('users.create', compact('roles', 'permissions', 'permission_groups'));
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
        if (is_null($this->user) || !$this->user->can('user.create')) {
            abort(403, 'SORRY! You are unauthorized to create user!');
        }

        $request->validate(
            [
                'name' => 'required|regex:/^[a-zA-Z ]+$/u|min:3|max:20',
                'email' => 'required|min:3|email|max:20|unique:users',
                'password' => 'required|min:6|confirmed',
            ],
            [
                'name.required' => 'User Name field is required.',
                'name.unique' => 'The User name has already been taken.',
                'name.regex' => 'The User name format is invalid. Please enter alpabatic text.',
                'name.min' => 'The User name must be at least 3 characters.',
                'name.max' => 'The User name may not be greater than 20 characters.'
            ]
        );
        $insertId = $this->users->insertUser($request);
        $permissions = $request->permissions;
        if (!empty($permissions)) {
            for ($i = 0; $i < count($permissions); $i++) {
                $insertId->givePermissionTo($permissions[$i]);
            }
        }
        if ($insertId) {
            Webspice::log($this->tableName, $insertId, "Data Created.");
            Session::flash('success', 'User Created Successfully.');
        } else {
            Session::flash('error', 'User not created!');
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
        #permission verify
        if (is_null($this->users) || !$this->users->can('user.view')) {
            abort(403, 'SORRY! You are unauthorized to show user!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        #permission verify
        if (is_null($this->user) || !$this->user->can('user.edit')) {
            abort(403, 'SORRY! You are unauthorized to edit user!');
        }
        $id = Crypt::decryptString($id);
        $user = $this->users->find($id);
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = Permission::select('group_name')->groupBy('group_name')->get();

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'permission_groups' => $permission_groups
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
        #permission verify
        if (is_null($this->user) || !$this->user->can('user.edit')) {
            abort(403, 'SORRY! You are unauthorized to edit user!');
        }

        $id = Crypt::decryptString($id);
        $user = $this->users->find($id);
        $request->validate(
            [
                'name'     => 'required|regex:/^[a-zA-Z ]+$/u|min:3|max:50',
                'email'    => 'required|min:3|email|max:20|unique:users,email,' . $id,
                'password' => 'nullable|min:6|confirmed',
            ],
            [
                'name.required' => 'User Name field is required.',
                'name.unique'   => 'The User name has already been taken.',
                'name.regex'    => 'The User name format is invalid. Please enter alpabatic text.',
                'name.min'      => 'The User name must be at least 3 characters.',
                'name.max'      => 'The User name may not be greater than 20 characters.'
            ]
        );
        $result = $this->users->updateUser($request, $id);
        $permissions = $request->permissions;
        if (!empty($permissions)) {
            $user->syncPermissions($permissions);
        }
        if ($result) {
            # write log
            Webspice::log($this->tableName, $id, "Data updated.!");
            Session::flash('success', 'User has been updated successfully.');
        } else {
            Session::flash('error', 'User not updated!');
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
        #permission verify
        if (is_null($this->user) || !$this->user->can('user.delete')) {
            abort(403, 'SORRY! You are unauthorized to delete user!');
        }

        $id = Crypt::decryptString($id);
        $user = $this->users->find($id);
        if (!is_null($user)) {
            $result = $user->delete();
        }
        if ($result) {
            Webspice::log($this->tableName, $id, "Data deleted.");
            Session::flash('success', 'User deleted Successfully.');
        } else {
            Session::flash('error', 'User not deleted!');
        }
        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        if ($request->all()) {
            $request->validate(
                [
                    'old_password' => 'required',
                    'new_password' => 'required|min:6|confirmed'
                ],
                [
                    'name.required' => 'Password is required.',
                    'password.min' => 'Password must be at least 6 characters.'
                ]
            );
            #Match The Old Password
            if(!Hash::check($request->old_password, auth()->user()->password)){
                return back()->with("error", "Old Password Doesn't match!");
            }

            #Update the new Password
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            Webspice::log($this->tableName, auth()->user()->id, "Password changed.");
            return back()->with("success", "Password changed successfully!");
        }
        return view('users.change-password');
    }

    public function userProfile()
    {
        return view('users.user-profile');
    }
}
