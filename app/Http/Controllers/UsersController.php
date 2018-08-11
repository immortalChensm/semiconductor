<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
class UsersController extends Controller
{
    public function __construct()
    {
        //users控制器  除了show,create,stroe方法以外，其它均要登录授权才可以访问
        $this->middleware('auth',[
            'except'=>['show','create','store','index','confirmEmail','sendEmailConfirmationTo']
        ]);

        $this->middleware("guest",[
            "only"=>["create"]
        ]);
    }

    public function confirmEmail($token)
    {
        $user = User::where("activation_token",$token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();
        Auth::login($user);

        session()->flash("success","账号激活成功");
        return redirect()->route("users.show",[$user]);
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

        $statuses = $user->statuses()->orderBy("created_at","desc")->paginate(30);
        return view("users.user",compact('user','statuses'));
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

        //session()->flash("success","you register is ok");
        //Auth::login($user);
        //return redirect()->route("users.show",[$user]);
        $this->sendEmailConfirmationTo($user);
        session()->flash("success","邮件已经发送，请查收");
        return redirect("/");
    }

    public function sendEmailConfirmationTo($user)
    {
        $view = "email.confirm";
        $data = compact('user');
        $from = "1655664358@qq.com";
        $name = "jackcsm";
        $to = "csmgydx@163.com";
        $subject = "感觉注册ls";

        Mail::send($view,$data,function ($message)use($from,$name,$to,$subject){
            $message->from($from,$name)->to($to)->subject($subject);
        });
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
