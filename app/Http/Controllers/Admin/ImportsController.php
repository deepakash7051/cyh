<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCSVUserRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\MassDestroyCategoryRequest;
use Freshbitsweb\Laratables\Laratables;
use App\Role;
use App\User;
use App\RoleUser;

class ImportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        abort_unless(\Gate::allows('user_create'), 403);

        return view('admin.imports.user');
    }

    public function parseusers(StoreCSVUserRequest $request)
    {
        $path = $request->file('attachment')->getRealPath();
        $file = $request->file('attachment');
        $data = array_map('str_getcsv', file($path));
        $csv_data = array_slice($data, 0, 1);

        return view('admin.imports.parseuser', compact('data', 'csv_data', 'file'));
    }

    public function saveusers(StoreCSVUserRequest $request)
    {
        $path = $request->file('attachment')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        //$csv_data = array_slice($data, 0, 1);
        array_shift($data);

        if(count($data) > 0){
            foreach($data as $user){
                $query = User::where('email', $user[1])->orWhere('phone', $user[3]);
                if($query->count()==0){
                    $newuser = User::create([
                        'name' => $user[0],
                        'email' => $user[1],
                        'isd_code' => $user[1],
                        'phone' => $user[3],
                        'password' => bcrypt($user[3])
                    ]);

                    $newuser->roles()->sync('4');
                }
            }
        }

        return redirect()->route('admin.users.index');
        
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('category_create'), 403);

        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        abort_unless(\Gate::allows('category_create'), 403);

        /*echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        exit();*/

        $category = Category::create($request->all());

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('category_show'), 403);

        $category = Category::find($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('category_edit'), 403);
        $category = Category::find($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        abort_unless(\Gate::allows('category_edit'), 403);

        $category = Category::find($id);
        $category->update($request->all());

        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('category_delete'), 403);

        $category = Category::find($id);
        $category->delete();

        return back();
    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        Category::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }

    public function getCustomColumnDatatablesData()
    {
        return Laratables::recordsOf(Category::class);
    }
}
