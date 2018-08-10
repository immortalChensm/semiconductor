<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UsersController extends Controller
{
    //
    public function create()
    {
        return view("users.create");
    }

    public function show(User $user){
        return view("users.user",compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:2',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:6'
        ]);

        $user = User::create([
            "name"=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        session()->flash("success","you register is ok");
        Auth::login($user);
        return redirect()->route("users.show",[$user]);
    }
}
