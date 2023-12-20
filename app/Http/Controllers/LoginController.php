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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


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
        $user = User::with('pemungut')
        ->where('active', '1')
        ->where('email', $login)
        ->orWhere('username', $login)->first();
        
        if (!$user) {
            return redirect()->back()->withErrors(['username' => 'Invalid login credentials']);
        }
        $remember =  $request->remember ? true : false;
        // Login using email or username
        if (Auth::attempt(['email' => $user->email, 'password' => $request->password],$remember)
        || Auth::attempt(['username'=> $user->username,'password' => $request->password],$remember)) {
                    // URL API Login Peruri
                        if(env('APP_ENV')=='production'){
                            // PRD
                            $API_LOGIN = 'https://backendservice.e-meterai.co.id/api/users/login';
                        }else{
                            // DEV
                            $API_LOGIN = 'https://backendservicestg.e-meterai.co.id/api/users/login';
                        } 
                        if($user->pemungut->p_user==null || $user->pemungut->p_password==null){
                            $request->session()->regenerate(); 
                            return redirect()->intended('dashboard');
                        }     
                    try {
                        $response_api = Http::withHeaders([
                            'Content-Type' => 'application/json; charset=utf-8',
                        ])->withBody(json_encode([
                            'user' => $user->pemungut->p_user,//env('EMATRERAI_USER'),
                            'password' => Crypt::decrypt($user->pemungut->p_password),// env('EMATRERAI_PASSWORD'),
                        ]))->post($API_LOGIN);
                        // if(!$response_api->failed()){
                        //     $response_api->post($API_LOGIN);
                        // }
                        if($response_api->successful()){
                            if($response_api['message']=='success'){ 
                                $e_token = User::find($user->id); 
                                $e_token->postal = $response_api['result']['data']['login']['user']['id'];
                                $e_token->address = $response_api['result']['data']['login']['user']['userdetails'][0]['locationother'][0]['id'];
                                $e_token->ematerai_token = $response_api['token'];
                                $e_token->update();
                                //dd($response_api['result']['data']['login']['user']['userdetails']['locationother']['id']);
                                Log::info($response_api['result']);
                                Log::info('peruri servise success');
                            }else{
                                $e_token = User::find($user->id); 
                                $e_token->ematerai_token = 'LOGIN_FAILED';
                                $e_token->update();
                                Log::error('LOGIN_FAILED peruri servise failed');
                            }
                        }
                        
                    } catch (\Exception $e) {
                        //Execp $e;
                        Log::error('peruri servise failed'.$e);
                    }
            $request->session()->regenerate(); 
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
           
            return redirect('/');
        }
        return redirect('/');    
    }
}
