<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Freshbitsweb\Laratables\Laratables;
use App\Role;
use App\User;
use App\RoleUser;
use Auth;
use App\Category;
use App\Course;

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

    public function getCourses(Request $request)
    {
        $query = Course::where('status', '1');
        if($request->categories && count($request->categories) > 0){
            $query = $query->whereIn('Category_id', $request->categories);
        }
        return $courses = $query->get();
         
    }

    public function create()
    {
        abort_unless(\Gate::allows('user_create'), 403);

        $user = auth()->user();
        $roleid = RoleUser::where('user_id', $user->id)->min('role_id');
        $roles = Role::where('id', '>', $roleid)->pluck('title', 'id');

        $categoryname = config('app.locale').'_name';
        $categories = Category::where('status', '1')->pluck($categoryname, 'id');

        $coursetitle = config('app.locale').'_title';
        $courses = Course::where('status', '1')->pluck($coursetitle, 'id');

        return view('admin.users.create', compact('roles', 'categories', 'courses'));
    }

    public function store(StoreUserRequest $request)
    {
        abort_unless(\Gate::allows('user_create'), 403);

        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        $user->categories()->sync($request->input('categories', []));
        $user->courses()->sync($request->input('courses', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_unless(\Gate::allows('user_edit'), 403);

        $authuser = auth()->user();
        $roleid = RoleUser::where('user_id', $authuser->id)->min('role_id');
        $roles = Role::where('id', '>', $roleid)->pluck('title', 'id');

        $categoryname = config('app.locale').'_name';
        $categories = Category::where('status', '1')->pluck($categoryname, 'id');

        $coursetitle = config('app.locale').'_title';
        $courses = Course::where('status', '1')->pluck($coursetitle, 'id');

        $user->load('courses');
        $user->load('roles');
        $user->load('categories');
        
        return view('admin.users.edit', compact('roles', 'user', 'categories', 'courses'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        abort_unless(\Gate::allows('user_edit'), 403);

        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        $user->categories()->sync($request->input('categories', []));
        $user->courses()->sync($request->input('courses', []));

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
