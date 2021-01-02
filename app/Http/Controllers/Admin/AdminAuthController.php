<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{

    public function login()
    {
        return view('admin.auth.login');
    }

    public function doLogin(Request $request){

        $this->validate($request,[
            'email'         => 'required',
            'password'      => 'required',
        ]);

        //$rememberme = request('rememberme') == 1 ? true: false;
        if(Auth::guard('admin')->attempt(['email'=>request('email'), 'password'=>request('password')])) {
          return   redirect(url('admin/home'));
        } else {
            session()->flash('error', ('admin errors'));
            return redirect('admin/login');
        }
    }

    public function register()
    {
        return view('admin.auth.register');
    }

    public function doRegister(Request $request)
    {
        $this->validate($request,[
            'name'                  => 'required',
            'email'                 => 'required|unique:admins',
            'phone'                 => 'required|unique:admins',
            'password'              => 'required|confirmed'
        ]); 

        //dd($request->all());
        $request->merge(['password' => bcrypt($request->password)]);
        $admin = Admin::create($request->all());
        //$admin->api_token = Str::random(60);
        $admin->save();

        return redirect('admin/login');
    }

    public function logout(){
        auth()->guard('admin')->logout();
        return redirect('admin/login'); 
    }


}
