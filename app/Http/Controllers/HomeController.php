<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Directory;
use App\Models\Document;
use App\Models\Serialnumber;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Coduo\PHPHumanizer\NumberHumanizer;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    use HasRoles;
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
    public function index(Request $request)
    {
        $saldo = 0;
        $notstamp = 0;
        # role admin
        //$role_admin = User::role('Superadmin','Admin')->get();
        //$role_admin = Auth::user()->hasRole('Admin');
        if(Auth::user()->hasRole('Admin')){
            try {
                $Url = config('sign-adapter.API_CHECK_SALDO');
                $requestAPI = (string) Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . Auth::user()->ematerai_token,
                ])->post($Url);
                $response = json_decode($requestAPI,true)['result'];
                // dd($response);
                if(isset($response['status'])){
                    if($response['status']=='00'){
                        $saldo = $response['saldo'];
                        $notstamp = $response['notstamp']; 
                    }
                }
            }catch (\Exception $e) {
                //throw $th;
                Log::error($e->getMessage());
            }
            $per_page = (int) $request->input('view') ?  $request->input('view'):1000000;  
            $users = User::with('pemungut')->latest()
            ->where('active','<>','2')
            ->filter(request()->all())->paginate(10)->onEachSide(0);
            if($s = $request->s){
                $users = User::with('pemungut')->latest()
                ->where('active','<>','2')
                ->where('username','like','%'.$s.'%')
                ->orWhere('email','like','%'.$s.'%')
                ->orderBy('created_at', 'desc')
                ->filter(request()->all())->paginate(10)->onEachSide(0);
            }
            $datas =[
                "COUNT_MATERAI" => $saldo,
                "COUNT_MATERAI_NOSTEMP" => $notstamp,
                'COUNT_DOCUMENT' => Document::whereNot('certificatelevel','DELETED')->count(),
                'COUNT_NOT_CERTIFIED' => Document::where(['certificatelevel'=>'NOT_CERTIFIED'])->count(),
                'COUNT_SUCCESS' => Document::where(['certificatelevel'=>'CERTIFIED'] )->count(),
                'COUNT_FAILUR' => Document::where(['certificatelevel'=>'FAILUR'] )->count(),
                "NOT_STAMPED" => Document::whereNotIn('certificatelevel',['CERTIFIED','DELETED'])->count(),
                "STAMPTING" => Document::where('certificatelevel','=','CERTIFIED')->orderBy('updated_at', 'desc')
                ->paginate(5,['*'],'stemp_page')->setPageName('stemp_page'),
                "NOT_STAMPTING" => Document::where('certificatelevel','<>','CERTIFIED')->orderBy('updated_at', 'desc')
                ->paginate(5,['*'],'nostemp_page')->setPageName('nostemp_page'),
                // "USERS" => $users,
            ];
            return view('admin.dashboard', compact('datas','users'));

        }else if(Auth::user()->hasRole('Client')){
           // // user
            // $datas =[
            //     'COUNT_DOCUMENT' => NumberHumanizer::metricSuffix(Document::where(['user_id'=> Auth::user()->id])->count()??0),
            //     'COUNT_NOT_CERTIFIED' => NumberHumanizer::metricSuffix(Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'NOT_CERTIFIED'] )->count()),
            //     'COUNT_SUCCESS' => NumberHumanizer::metricSuffix(Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'CERTIFIED'] )->count()),
            //     'COUNT_FAILUR' => NumberHumanizer::metricSuffix(Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'FAILUR'] )->count()),
            //     "NOT_STAMPED" => NumberHumanizer::metricSuffix(Document::where('user_id',Auth::user()->id)->where('certificatelevel','<>','CERTIFIED') ->count()),
            //     "STAMPTING" => Document::where('user_id',Auth::user()->id)->where('certificatelevel','=','CERTIFIED')->orderBy('updated_at', 'desc')
            //     ->paginate(5,['*'],'stemp_page')->setPageName('stemp_page'),
            //     "NOT_STAMPTING" => Document::where('user_id',Auth::user()->id)->where('certificatelevel','<>','CERTIFIED')->orderBy('updated_at', 'desc')
            //     ->paginate(5,['*'],'nostemp_page')->setPageName('nostemp_page'),
            // ];
            $saldo = 0;
            $notstamp = 0;
            $totalUnUsed = 0;
            $totalUsed = 0;
            $daftarSN = [];
            $DATA_STAMP = [];
            
            try {
                $Url = config('sign-adapter.API_CHECK_SALDO');
                $requestAPI = (string) Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . Auth::user()->ematerai_token,
                ])->post($Url);
                $response = json_decode($requestAPI,true);
                //dd($response);
                if(isset($response['result']['status'])){
                    if($response['result']['status']=='00'){
                        $saldo = $response['result']['saldo'];
                        $notstamp = $response['result']['notstamp']; 
                    }
                }    
            } catch (\Exception $e) {
                //throw $th;
                Log::error($e->getMessage());
            }
            //CEK NOTSTAMP
            // try {
            //     $query = [
            //         Auth::user()->postal,
            //         'start'=>0,
            //         'length'=>100,
            //         'status'=>'NOTSTAMP',
            //         'notEncrypt'=>'true',
            //     ];
            //     $Urls = (string) config('sign-adapter.API_CHECK_DAFTAR_SN');
            //     $requestAPIs =  Http::withHeaders([
            //         'Content-Type' => 'application/json',
            //         'Authorization' => 'Bearer ' . Auth::user()->ematerai_token,
            //     ])->withUrlParameters($query)->get($Urls,$query);
            //     $responses = json_decode($requestAPIs,true);
            //     //dd($requestAPIs,$responses);
            //     if(isset($responses['result'])){
            //         if($responses['result']['total']!='0'){
            //             $totalUnUsed = $responses['result']['total'];
            //             //$notstamp = $response['notstamp']; 
            //         }
            //     }   
                
            // } catch (\Exception $e) {
            //     //throw $th;
            //     Log::error($e->getMessage());
            // }
            //CEK STAMP
            try {
                $query = [
                    Auth::user()->postal,
                    'start'=>0,
                    'length'=>100,
                    'status'=>'STAMP',
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
                    if($responses['result']['total']!=0){
                        $totalUsed = $responses['result']['total'];
                        $DATA_STAMP = $responses['result'];
                        //$notstamp = $response['notstamp']; 
                    }
                }   
                
            } catch (\Exception $e) {
                //throw $th;
                Log::error($e->getMessage());
            }
            
            $datas =[
                "COUNT_MATERAI" => $saldo,
                "COUNT_MATERAI_NOSTEMP" => $notstamp,
                'COUNT_MATERAI_NOTSTAMP' => $notstamp, //$totalUnUsed,
                'COUNT_MATERAI_STAMP' => $totalUsed,
                'DATA_STEMP' => $DATA_STAMP,
                'COUNT_DOCUMENT' => (Document::where(['user_id'=> Auth::user()->id])->whereNot('certificatelevel','DELETED')->count()??0),
                'COUNT_NOT_CERTIFIED' => (Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'NOT_CERTIFIED'])->count()),
                'COUNT_SUCCESS' => (Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'CERTIFIED'] )->count()),
                'COUNT_FAILUR' => (Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'FAILUR'] )->count()),
                "NOT_STAMPED" => (Document::where('user_id',Auth::user()->id)->where('certificatelevel','=','NEW')
                //->whereNotIn('certificatelevel',['CERTIFIED','FAILUR','DELETED'])
                ->count()),
                "STAMPTING" => Document::where('user_id',Auth::user()->id)->where('certificatelevel','=','CERTIFIED')->orderBy('updated_at', 'desc')
                ->paginate(5,['*'],'stemp_page')->setPageName('stemp_page'),
                "NOT_STAMPTING" => Document::where('user_id',Auth::user()->id)->whereNotIn('certificatelevel',['CERTIFIED','DELETED'])->orderBy('updated_at', 'desc')
                ->paginate(5,['*'],'nostemp_page')->setPageName('nostemp_page'),
            ];
            return view('pages.dashboard', compact('datas'));
        }else{
            
            //dd(Auth::user(),Auth::user()->hasRole('Client'));
            //return Auth::user()->hasRole('Client');
            //norule
            return abort(404);
        }
        
    }
}
