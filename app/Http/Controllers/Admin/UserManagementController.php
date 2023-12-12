<?php

namespace App\Http\Controllers\Admin;

use App\Adapter\SignAdapter;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Pemungut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

class UserManagementController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $users = User::orderBy('id','DESC')->latest()
        ->filter(request()->all())->paginate(10)->onEachSide(0);;
        if($s = $request->s){
            $users = User::with('pemungut')->latest()
            ->where('username','like','%'.$s.'%')
            ->orWhere('email','like','%'.$s.'%')
            ->orderBy('created_at', 'desc')
            ->filter(request()->all())->paginate(10)->onEachSide(0);
            // ->paginate(10);
        }
        return view('admin.users.user',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.users.create',compact('roles'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'active' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        //$input['active'] = 1;

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$user = User::find($id);
        $user = User::with('pemungut')->find($id);
        $pass = ($user->pemungut->p_password)? Crypt::decrypt($user->pemungut->p_password):'' ;
        if($user==null){
            return redirect()->route('users.index')
                   ->with('error','User not Found!');
        }
        return view('admin.users.show',compact('user','pass'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if($user==null){
            return redirect()->route('users.index')->with('error','User not Found!');
        }
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('admin.users.edit',compact('user','roles','userRole'));
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
        $this->validate($request, [
            'username' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'active' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    public function active(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'id' => 'required',
            'active' => 'required',
        ]);
        $active = User::find($input['id']);
        $active->active = $input['active'] ;
        $active->update();
        if($input['active']==1){
            return redirect()->route('users.index')
            ->with('success',"User ".$active->username." Active successfully");
        }else{
            return redirect()->route('users.index')
            ->with('success',"User ".$active->username." Block successfully");
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User Delete successfully');
    }


    //TODO service akun
    public function setpemungut(Request $request){
        $request->validate([
            'user'=> 'required',
            'username'=> 'required',
            'password'=> 'same:confirm-password',
        ]);
        $input = $request->all();
        $pemungut = Pemungut::updateOrCreate(['user_id'=>$input['user']],
            [
                'p_user'=> $input['username'],
                'p_password'=> Crypt::encrypt($input['password'])
            ]);
        return redirect()->back()->with('success', 'Account saved successfully ');    
    } 

    public function checkpemungut(Request $request){
        $request->validate([
            'username'=> 'required',
            'password'=> 'required',
        ]);
        $input = $request->all();
        return SignAdapter::validUser($input['username'],$input['password']);
    }
    public function test(){
        //return SignAdapter::getJenisDocument();
        return SignAdapter::exeSreialStamp([23]);
        //return SignAdapter::setToken(3);
        return SignAdapter::getTokenUser([1]);
    }
}
