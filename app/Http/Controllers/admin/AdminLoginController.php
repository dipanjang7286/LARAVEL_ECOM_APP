<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendLoginMailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    // public function authenticate(Request $request){
    //     $validator = Validator::make($request->all(),[
    //         'email'=>'required',
    //         'password'=>'required',
    //     ]);

    //     if($validator->passes()){
    //         if(Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
    //             $admin = Auth::guard('admin')->user();
    //             if((int)$admin->role === 2){ // admin
    //                 return redirect()->route('admin.dashboard');
    //             }else{
    //                 Auth::guard('admin')->logout();
    //                 return redirect()->route('admin.login')->with('error','You have no access of this page');
    //             }
    //         }else{
    //             return redirect()->route('admin.login')->with('error','Either email or password is incorrect');
    //         }
    //     }else{
    //         return redirect()->route('admin.login')->withErrors($validator)->withInput($request->only('email'));
    //     }
    // }


    public function authenticate(Request $request){

        $request->validate(
            [
                "email"=> "required",
                "password"=>"required",
            ],
            [
                "email.required"=> "The email is empty!! Please enter email.",
                "password.required"=> "The password is empty!! Please enter password",
            ]
        );

        if(Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password], $request->get('remember'))){

            // login mail send
            $name = Auth::guard('admin')->user()->name;
            if(Auth::guard('admin')->user()->role ==2){
                SendLoginMailJob::dispatch($request->email, $name, 30)->onQueue('emails');
            }

            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('admin.login')->with('error','Either email or password is incorrect');
        }   
    }
}
