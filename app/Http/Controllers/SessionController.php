<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionController extends Controller
{
    public function __construct()
    {
        //该控制器仅仅允许未登录的用户访问create方法
        $this->middleware("guest",[
            "only"=>["create"]
        ]);
    }

    //
    public function create()
    {
        return view("session.create");
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            "email"=>"required|email:max:255",
            "password"=>"required"
        ]);

        if(Auth::attempt($credentials,$request->has("remember"))){

            if(Auth::user()->activated){

                session()->flash("success","login success");
                //return redirect()->route("users.show",[Auth::user()]);
                return redirect()->intended(route("users.show",[Auth::user()]));

            }else{
                Auth::logout();
                session()->flash("warning","警告，你的账号未激活");
                return redirect("/");
            }

        }else{
            session()->flash("danger","your password or email account is error");
            return redirect()->back();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash("success","you have logout");
        return redirect()->route("login");
    }

}
