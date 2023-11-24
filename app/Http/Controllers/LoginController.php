<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;


class LoginController extends Controller
{  
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            // 'email' => ['required', 'email'],
            'username' => ['required'],
            'password' => ['required'],
        ]);


        $login = $request->input('username');
        $user = User::where('email', $login)->orWhere('username', $login)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['username' => 'Invalid login credentials']);
        }
        $remember =  $request->remember ? true : false;
        // Login using email or username
        if (Auth::attempt(['email' => $user->email, 'password' => $request->password],$remember)
        || Auth::attempt(['username'=> $user->username,'password' => $request->password],$remember)) {
            $request->session()->regenerate(); 

                    // URL API Login Peruri
                        if(env('APP_ENV')=='production'){
                            // PRD
                            $API_LOGIN = 'https://backendservice.e-meterai.co.id/api/users/login';
                        }else{
                            // DEV
                            $API_LOGIN = 'https://backendservicestg.e-meterai.co.id/api/users/login';
                        }  
                    $response_api = Http::withHeaders([
                            'Content-Type' => 'application/json; charset=utf-8',
                        ])->withBody(json_encode([
                            'user' => env('EMATRERAI_USER'),
                            'password' => env('EMATRERAI_PASSWORD'),
                        ]))->post($API_LOGIN);
                        if($response_api['message']=='success'){ 
                            $e_token = User::find($user->id); 
                            $e_token->ematerai_token = $response_api['token'];
                            $e_token->update();
                        }
            return redirect()->intended('dashboard');
        }
        if(!Auth::validate($credentials)):
            return redirect()->to('login')->withErrors(trans('auth.login'));
        endif;
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Cookie::make('_token_ematerai','',-120,'/');
        Cookie::make('m_ematerai','', -120,'/');
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $response = ['message' => 'You have been successfully logged out!'];
            response($response, 200);
           
            return redirect('/login');
        }
        return redirect('/login');    
    }
}
