<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
class AdminController extends Controller
{
    

    public function dashboard(){
        return view('admin.dashboard');
    }
    public function login(){
        return view('admin.login');
    }
    public function login_submit(Request $request){
//dd($request->all());
        $request->validate([
        'email' => 'required|email',
        'password' => 'required',
       ]);
       //return redirect()->route('admin.dashboard');
       $check = $request->all();
       $data = [
          'email' =>$check['email'],
          'password' => $check['password'],
       ];
       if (Auth::guard('admin')->attempt($data)){
         return redirect()->route('admin_dashboard')->with('success','login successfull');
       }else{
         return redirect()->route('admin_login')->with('error','invalid credentails');
       }
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login')->with('success', 'logout successfully');
    }
}
