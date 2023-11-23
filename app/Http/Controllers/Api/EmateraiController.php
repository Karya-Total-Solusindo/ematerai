<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class EmateraiController extends Controller
{   
    public $API_LOGIN,
    $API_GENERATE_SERIAL_NUMBER,
    $API_GENERATE_SERIAL_NUMBER_BULK,
    $API_STEMPTING,
    $API_JENIS_DOCUMENT,
    $API_CHECK_SERIAL_NUMBER,
    $API_GENERATE_QR,
    $API_CHECK_BATCH_ID,
    $API_GET_SN_QR_IMAGE,
    $API_CHECK_SALDO,
    $API_CHECK_SALDO_PEMUNGUT,
    $API_UPDATE_DATA_STEMTING,
    $API_CHECK_DAFTAR_SN
    ;
    private $minutes = +120;
    function __construct(){
        // environment set
        if(env('APP_ENV')=='production'){
            // E-meterai Production Access On Premise Service
            $this->API_LOGIN = 'https://backendservice.e-meterai.co.id/api/users/login';
            $this->API_GENERATE_SERIAL_NUMBER = 'https://stampv2.e-meterai.co.id/chanel/stampv2';
            $this->API_GENERATE_SERIAL_NUMBER_BULK = 'https://inventory.e-meterai.co.id/api/v2/serialnumber/batch';
            $this->API_STEMPTING = '{{keystamp}}/adapter/pdfsigning/rest/docSigningZ';
            // API Stamping (Sign Adapter):
            // {{keystamp}}/adapter/pdfsigning/rest/docSigningZ
            // {{keystamp}} merupakan domain dari docker adapter yang di deploy di sisi client
            $this->API_JENIS_DOCUMENT = 'https://stampv2.e-meterai.co.id/jenisdoc';
            $this->API_CHECK_SERIAL_NUMBER = 'https://backendservice.e-meterai.co.id/api/chanel/stamp/ext';
            $this->API_GENERATE_QR = 'https://stampv2.e-meterai.co.id/snqr/qrimage';
            $this->API_CHECK_BATCH_ID ='https://stampv2.e-meterai.co.id/snqr/status-batch';
            $this->API_GET_SN_QR_IMAGE = 'https://stampv2.e-meterai.co.id/snqr';
            $this->API_CHECK_SALDO = 'https://backendservice.e-meterai.co.id/function/saldopos';
            $this->API_CHECK_SALDO_PEMUNGUT = 'https://backendservice.e-meterai.co.id/sale/saldo-scm?idLoc=[idPemungut]&db=true';
            //idPemungut didapat dari response API Login pada response body “Id” dengan “description”:“PEMUNGUT”
            $this->API_UPDATE_DATA_STEMTING = 'https://stampv2.e-meterai.co.id/stamping/update-data/[SerialNumber]';
            //Serial Number dengan status NOT-STAMP yang telah tergenerate, dan akan diupdate
            $this->API_CHECK_DAFTAR_SN = 'https://stampv2.e-meterai.co.id/chanel/sale/stamp/ext/[UserID]';
        }else{
              // E-meterai Staging Access On Premise Service
              $this->API_LOGIN = 'https://backendservicestg.e-meterai.co.id/api/users/login';
              //Login dilakukan untuk mendapatkan token JWT dan berlaku selama 1x24 jam
              $this->API_GENERATE_SERIAL_NUMBER = 'https://stampv2stg.e-meterai.co.id/chanel/stampv2';
              $this->API_GENERATE_SERIAL_NUMBER_BULK = 'https://inventorystg.e-meterai.co.id/api/v2/serialnumber/batch';
              $this->API_STEMPTING = '{{keystamp}}/adapter/pdfsigning/rest/docSigningZ';
              // API Stamping (Sign Adapter):
              // {{keystamp}}/adapter/pdfsigning/rest/docSigningZ
              // {{keystamp}} merupakan domain dari docker adapter yang di deploy di sisi client
              $this->API_JENIS_DOCUMENT = 'https://stampv2stg.e-meterai.co.id/jenisdoc';
              $this->API_CHECK_SERIAL_NUMBER = 'https://backendservicestg.e-meterai.co.id/api/chanel/stamp/ext';
              $this->API_GENERATE_QR = 'https://stampv2stg.e-meterai.co.id/snqr/qrimage';
              $this->API_CHECK_BATCH_ID ='https://stampv2stg.e-meterai.co.id/snqr/status-batch';
              $this->API_GET_SN_QR_IMAGE = 'https://stampv2stg.e-meterai.co.id/snqr';
              $this->API_CHECK_SALDO = 'https://backendservicestg.e-meterai.co.id/function/saldopos';
              $this->API_CHECK_SALDO_PEMUNGUT = 'https://backendservicestg.e-meterai.co.id/sale/saldo-scm?idLoc=[idPemungut]&db=true';
              //idPemungut didapat dari response API Login pada response body “Id” dengan “description”:“PEMUNGUT”
              $this->API_UPDATE_DATA_STEMTING = 'https://stampv2stg.e-meterai.co.id/stamping/update-data/[SerialNumber]';
              //Serial Number dengan status NOT-STAMP yang telah tergenerate, dan akan diupdate
        }
    }
    /**
     * Display a listing of the resource.
     * Login Sign-Adapter
     */
    public function index()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->withBody(json_encode([
            'user' => env('EMATRERAI_USER'),
            'password' => env('EMATRERAI_PASSWORD'),
        ]))->post($this->API_LOGIN);   

            $responseC = response($response);
            $responseC->withCookie(cookie('_token_ematerai',$response['token'], $this->minutes,'/'));
            // return $responseC;
        if($response['message'] == 'success'){ 

        }
        return $response['token'];
    }

    public function login(Request $request){
        // echo config('sign-adapter.API_LOGIN');
        // $decrypted = Crypt::decrypt(Cookie::get('_token_ematerai'),false);
        $decrypted = Cookie::get('_token_ematerai');
        $d = json_decode(Str::of($decrypted)->explode("|"));
        // dd(Str::of($decrypted)->explode("|")[1]);
        return response()->json($d);
        return response()->json(['success'=>'API '.$this->API_LOGIN]);
    }

    /**
     * API_GENERATE_SERIAL_NUMBER Ematerai .
     */
    public function getSN()
    {   
        $Url = config('sign-adapter.API_GENERATE_SERIAL_NUMBER');
        // $decrypted = Crypt::decryptString(Cookie::get('_profile_ematerai'),false);
        $decrypted = Cookie::get('_profile_ematerai');
        $d = json_decode(Str::of($decrypted)->explode("|"));
        return response()->json($d);
    }
}
