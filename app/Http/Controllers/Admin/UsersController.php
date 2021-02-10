<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Freshbitsweb\Laratables\Laratables;
use App\Role;
use App\User;
use App\RoleUser;
use Auth;

class UsersController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('user_access'), 403);

        $users = User::all();

        return view('admin.users.index');
    }

    public function list()
    {
        abort_unless(\Gate::allows('user_access'), 403);

        $user = auth()->user();
        $roleid = RoleUser::where('user_id', $user->id)->min('role_id');
        $roleToExclude = [];
        for($i=0; $i<= $roleid; $i++){
            array_push($roleToExclude, $i);
        }

        return Laratables::recordsOf(User::class, function($query)  use ($roleToExclude) 
        {
            return $query->whereDoesntHave('roles', function($query) use ($roleToExclude){
                $query->whereIn('id', $roleToExclude);
            });
        });

    }

    public function create()
    {
        abort_unless(\Gate::allows('user_create'), 403);

        $user = auth()->user();
        $roleid = RoleUser::where('user_id', $user->id)->min('role_id');
        $roles = Role::where('id', '>', $roleid)->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        abort_unless(\Gate::allows('user_create'), 403);

        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_unless(\Gate::allows('user_edit'), 403);

        $authuser = auth()->user();
        $roleid = RoleUser::where('user_id', $authuser->id)->min('role_id');
        $roles = Role::where('id', '>', $roleid)->pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        abort_unless(\Gate::allows('user_edit'), 403);

        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_unless(\Gate::allows('user_show'), 403);

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_unless(\Gate::allows('user_delete'), 403);

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
