<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;
use Illuminate\Support\Str;
use LangleyFoxall\ReactDynamicDataTableLaravelApi\DataTableResponder;

class UserController extends Controller
{
    /**
     * Home screen after logging in. Shows a kanban board of job states when visited
     *
     * @return view Jobs view
     */
    public function index()
    {
        $usersWithRoles = [];
        $users = User::all();
        foreach ($users as $user) {
            $role = $user->roles->pluck('name')->toArray();
            $userWithRole = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => end($role)
            ];
            array_push($usersWithRoles, $userWithRole);
        }
        return view('users.index')->with('users', json_encode($usersWithRoles));
    }

    public function create()
    {
        $allUserRoles = Role::all()->toArray();
        return view('users.register')->with('roles', $allUserRoles);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => PasswordRules::register($request->email)
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(60); //function used by breeze on install
        $user->save();
        // get the selected role on the create user form by string and assign to the new user
        $role = Role::findByName($request->role);
        $user->assignRole($role);
        Session::flash('message', 'Job successfully created');
        return to_route('users.index');
    }

    public function show($id)
    {
        $user = User::with('roles')->where('id', '=', $id)->first();
        $role = $user->getRoleNames()[0];
        return view('users.show')->with('user', $user)->with('role', $role);
    }

    public function edit($id)
    {
        $user = User::with('roles')->where('id', '=', $id)->first();
        $roles = Role::all()->toArray();
        $role = $user->getRoleNames()[0];
        return view('users.edit')->with('user', $user)->with('userRoles', $roles)->with('role', $role);
    }

    public function update($id, Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);
        if (!empty($request->password)) {
            $this->validate($request, [
                'password' => PasswordRules::register($request->email)
            ]);
        }
        $user = user::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user->roles()->detach();
        $user->assignRole($request->role);
        $role = Role::findByName($request->role);
        //TODO: Test after form built to ensure the revoke works in this way
        $revokeRole = $user->getRoleClass();
        $user->removeRole((new $revokeRole));
        $user->assignRole($role);
        Session::flash('message', 'Job successfully Edited');
        return to_route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return to_route('users.index');
    }

    public function userlift(Request $request)
    {
        return (new DataTableResponder(User::class, $request))->setPerPage(10)->respond();
    }
}
