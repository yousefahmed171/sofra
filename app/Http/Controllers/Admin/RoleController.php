<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request, [
            'name'                  => 'required|unique:roles',
            'display_name'          => 'required',
            'permissions_list'      => 'required|array'
        ]);

        $role =  Role::create($request->all());
        $role->permissions()->attach($request->permissions_list); //attachRole
        flash()->success(' success add role & permissions ');
        return redirect('admin/roles');


        
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
        //
        $model = Role::findOrFail($id);
        return view('admin.roles.edit', compact('model'));
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
        //

        $this->validate($request, [
            'name'                  => 'required|unique:roles,name,'.$id,
            'display_name'          => 'required',
            'permissions_list'      => 'required|array'

        ]);
        $role = Role::findOrFail($id);
        $role->update($request->all());
        $role->permissions()->sync($request->permissions_list); //attachRole
        flash()->success(' success edit role & permissions ');
        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $record = Role::findOrFail($id);
        $record->delete();
        flash('Success Delete Role')->success();
        return redirect('admin/roles'); //return back();
    }
}
