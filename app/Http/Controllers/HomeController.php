<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
         // URL API Login Peruri
         if(env('APP_ENV')=='production'){
            // PRD
            $API_LOGIN = 'https://backendservice.e-meterai.co.id/api/users/login';
        }else{
            // DEV
            $API_LOGIN = 'https://backendservicestg.e-meterai.co.id/api/users/login';
        }  
        $response_api = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->withBody(json_encode([
            'user' => env('EMATRERAI_USER'),
            'password' => env('EMATRERAI_PASSWORD'),
        ]))->post($API_LOGIN);
        // set token peruri as cookie    
        if($response_api['message']=='success'){
            Cookie::queue('_token_ematerai',$response_api['token'], 120);
            Cookie::queue('m_ematerai',$response_api, 120);
            $TokenLoginPeruri = [
                // '_token_ematerai' => $response_api['token'],
                // '_profile_ematerai' => $response_api
            ];
            
            // $request->session()->regenerate(); 
            // return redirect()->intended('dashboard')->withCookies($cookie);
        }
        return view('pages.dashboard');
    }
}
