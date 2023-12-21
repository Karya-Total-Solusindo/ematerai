<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemungut;
use App\Models\Serialnumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class EmateraiController extends Controller
{   
    public function index()
    {
        $datas = Serialnumber::where('user_id','=',Auth::user()->id)
        ->get();
        return view('client.serialnumber.index',compact('datas'));
    }

    public function checkDaftarSerial(Request $request){
       // CEK SERIAL NUMBER STEM OR NOTSTAMP
           
       try {   
                $status = $request->get('status') ?? $request->get('search')['value']; 
                $query = [
                    Auth::user()->postal,
                    'start'=> $request->get('start') ?? 0,
                    'length'=> $request->get('length') ?? 100,
                    'status'=>  $status ?? 'NOTSTAMP',
                    'notEncrypt'=>'true',
                ];
                $Urls = (string) config('sign-adapter.API_CHECK_DAFTAR_SN');
                $requestAPIs =  Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . Auth::user()->ematerai_token,
                ])->withUrlParameters($query)->get($Urls,$query);
                $responses = json_decode($requestAPIs,true);
                //dd($requestAPIs,$responses);
               
                if(isset($responses['result'])){
                    $dataArray =[];    
                    $dataSN = $responses['result']['data'];
                    foreach ($dataSN as $key => $value) {
                        $user = Serialnumber::where('sn','=',$value['serialnumber'])
                                ->join('users','users.id','serialnumber.user_id')
                        ->first();
                        if($user){
                                // dd($user->username);
                            $isUser = str_contains($user->email,'@')? $user->email : '(DELETED) '. $user->about;
                                $td =[
                                    "user" => $isUser,
                                    'docId' => $user->dociment_id ?? null,
                                    "serialnumber" => $value['serialnumber'],
                                    "status"=> $value['status'],
                                    "file"=> $value['file'],
                                    "tgl"  => date_format(date_create($value['tgl']),'d/m/Y H:i:s'),
                                    "tglupdate" => date_format(date_create($value['tglupdate']),'d/m/Y H:i:s'),
                                ];
                        }else{
                                $td =[
                                    "user" => $value['email'],
                                    'docId' => $user->dociment_id ?? null,
                                    "serialnumber" => $value['serialnumber'],
                                    "status"=> $value['status'],
                                    "file"=> $value['file'],
                                    "tgl"  => date_format(date_create($value['tgl']),'d/m/Y H:i:s'),
                                    "tglupdate" => date_format(date_create($value['tglupdate']),'d/m/Y H:i:s'),
                                ];
                        }
                        
                        array_push($dataArray, $td);
                    }
                  
                    if($responses['result']['total']!='0'){
                        $totalUnUsed = $responses['result']['total'];
                        $data = [
                            'draw'=> $request->get('draw') ?? 1,
                            'recordsTotal'=> $responses['result']['total']?? 0,
                            // 'recordsFiltered' => $responses['result']['limit']?? 0,
                            'recordsFiltered' => $responses['result']['total'] ?? 1,
                            'data' => $dataArray,//$responses['result']['data'],
                            'search' => $request->get('search'),
                        ];
                        return response()->json( $data,200);
                        //$notstamp = $response['notstamp']; 
                    }
                }   
              
            } catch (\Exception $e) {
                //throw $th;
                Log::error($e->getMessage());
            }
            $data =['draw'=>0,'recordsTotal'=>0,'recordsFiltered'=>0,'data'=>[]];
        return response()->json($data,200);
    }


    /**
     * Display a listing of the resource.
     * Login Sign-Adapter
     */
    // public function index()
    // {
    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json'
    //     ])->withBody(json_encode([
    //         'user' => env('EMATRERAI_USER'),
    //         'password' => env('EMATRERAI_PASSWORD'),
    //     ]))->post($this->API_LOGIN);   

    //         $responseC = response($response);
    //         $responseC->withCookie(cookie('_token_ematerai',$response['token'], $this->minutes,'/'));
    //         // return $responseC;
    //     if($response['message'] == 'success'){ 

    //     }
    //     return $response['token'];
    // }

    public function view(Serialnumber $serialnumber){

    } 

    // public function login(Request $request){
    //     // echo config('sign-adapter.API_LOGIN');
    //     // $decrypted = Crypt::decrypt(Cookie::get('_token_ematerai'),false);
    //     $token = Auth::user()->ematerai_token;
    //     $userService = Pemungut::where('user_id','=',Auth::user()->id)->first();
        
    //     $response = (string) Http::withHeaders([
    //         'Content-Type' => 'application/json'
    //     ])->withBody(json_encode([
    //         'user' => $userService->p_user,
    //         'password' => Crypt::decrypt($userService->p_password),
    //     ]))->post($this->API_LOGIN);  
    //     $d = json_decode($response);
    //     // dd(Str::of($decrypted)->explode("|")[1]);
    //     return response()->json($d);
    // }

    /**
     * API_GENERATE_SERIAL_NUMBER Ematerai .
     */
    public function getSN()
    {   
        $Url = config('sign-adapter.API_GENERATE_SERIAL_NUMBER');
        // $decrypted = Crypt::decryptString(Cookie::get('_profile_ematerai'),false);
        $d = Auth::user()->ematerai_token;
    
        return response()->json($d);
    }
    /**
     * ===============================================
     * TODO - Ajax action 
     * ===============================================
     * 
    */
}
