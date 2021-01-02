<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = Admin::with('roles')->get();

        return view('admin.admins.index', compact('record'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $record = Role::pluck('name', 'id')->toArray();


        return view('admin.admins.create', compact('record'));
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
            'name'          => 'required',
            'password'      => 'required|confirmed|min:3',
            'email'         => 'required|email|string|max:255|unique:users',
            'phone'         => 'required',
            'admin_type'    => 'required'

        ]);

        $request->merge(['password' => bcrypt($request->password)]);
        $admin = Admin::create($request->all());
        $admin->roles()->attach($request->admin_type); //attachRole
 
        //$user->save();

        return redirect('admin/admins');
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
        $model = Admin::findOrFail($id);
        $record = Role::pluck('name', 'id')->toArray();
        return view('admin.admins.edit', compact('model', 'record'));
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
            'name'          => 'required',
            'password'      => 'confirmed|min:3',
            'email'         => 'required|email|string|max:255|unique:admins,email,'.$id,
            'phone'         => 'required|unique:admins,email,'.$id,
            'admin_type'    => 'required'

        ]);

        $record = Admin::findOrFail($id);

        $request->merge([]);

        $record->roles()->sync((array) $request->input('admin_type'));
 

        $record->update($request->all());

        if($request->has('password'))
        {
            $record->password = bcrypt($request->password);
        }

        $record->save();
        
        return redirect('admin/admins');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $record = Admin::findOrFail($id);
        $record->delete();
        flash('Success Delete Admin')->success();
        return redirect('admin/admins'); //return back();
    }
}
