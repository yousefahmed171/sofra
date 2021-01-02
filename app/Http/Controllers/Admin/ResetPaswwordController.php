<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class ResetPaswwordController extends Controller
{
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.password.edit', compact('admin'));
    }
 

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'password'              => 'required|confirmed'
        ]);
        $user = Admin::findOrFail($id);
        $request->merge(['password' => bcrypt($request->password)]);
        $user->update($request->all());
        flash('Success Update Password')->success();
        return back();
    }

}
