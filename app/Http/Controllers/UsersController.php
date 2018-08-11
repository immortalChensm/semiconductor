<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UsersController extends Controller
{
    public function __construct()
    {
        //users控制器  除了show,create,stroe方法以外，其它均要登录授权才可以访问
        $this->middleware('auth',[
            'except'=>['show','create','store','index']
        ]);

        $this->middleware("guest",[
            "only"=>["create"]
        ]);
    }

    public function index()
    {
        $users = User::paginate(10);
        return view("users.index",compact("users"));
    }
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

    public function edit(User $user)
    {
        //echo $user->id;
        //$this->authorize('update',$user);
        
        return view("users.edit",compact('user'));
    }

    public function update(User $user,Request $request)
    {
        $this->validate($request,[
            "name"=>"required|max:50",
            //"password"=>"required|confirmed|min:6"
            "password"=>"nullable|confirmed|min:6"
        ]);

        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
//        $user->update([
//            "name"=>$request->name,
//            "password"=>bcrypt($request->password)
//        ]);

        $user->update($data);
        return redirect()->route("users.show",[$user->id]);
    }

    public function destroy(User $user)
    {
        $this->authorize("destroy",$user);
        $user->delete();
        session()->flash("success","用户删除成功");
        return redirect()->back();
    }
}
