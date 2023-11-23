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
        // URL API Login Peruri
        if(env('APP_ENV')=='production'){
            // PRD
            $API_LOGIN = 'https://backendservice.e-meterai.co.id/api/users/login';
        }else{
            // DEV
            $API_LOGIN = 'https://backendservicestg.e-meterai.co.id/api/users/login';
        }  

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
            // login get token peruri
            $response_api = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->withBody(json_encode([
                'user' => env('EMATRERAI_USER'),
                'password' => env('EMATRERAI_PASSWORD'),
            ]))->post($API_LOGIN);
            // set token peruri as cookie    
            if($response_api['message']=='success'){
                $cookie = [
                    Cookie::make('_token_ematerai',$response_api['token'], 120),
                    Cookie::make('_profile_ematerai',$response_api, 120),
                ];
                $request->session()->regenerate(); 
                return redirect()->intended('dashboard')->withCookies($cookie);
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
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $response = ['message' => 'You have been successfully logged out!'];
            response($response, 200);
            $cookie = Cookie::make('_token_ematerai', null,-100);
            return redirect('/login')->withCookies([$cookie]);
        }
        return redirect('/login');    
    }
}
