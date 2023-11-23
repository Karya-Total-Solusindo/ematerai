<?php
namespace App\Adapter;

use Illuminate\Support\Facades\Http;
class SignAdapter
{
    public static $minutes = 120;
    static function getToken()
    {
        $Url = config('sign-adapter.API_LOGIN');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->withBody(json_encode([
            'user' => env('EMATRERAI_USER'),
            'password' => env('EMATRERAI_PASSWORD'),
        ]))->post($Url);   

            $responseC = response($response);
            $responseC->withCookie(cookie('_token_ematerai',$response['token'], self::$minutes,'/'));
            // return $responseC;
        if($response['message'] == 'success'){ 
            return $response['token'];
        }else{
            return $response['message'];
        }
    }
}