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
    public function index()
    {
        $saldo = 0;
        $notstamp = 0;
        # role admin
        //$role_admin = User::role('Superadmin','Admin')->get();
        $role_admin = Auth::user()->hasRole('Admin');

        if($role_admin){
            
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

            $datas =[
                "COUNT_MATERAI" => $saldo,
                "COUNT_MATERAI_NOSTEMP" => $notstamp,
                'COUNT_DOCUMENT' => Document::count(),
                'COUNT_NOT_CERTIFIED' => Document::where(['certificatelevel'=>'NOT_CERTIFIED'] )->count(),
                'COUNT_SUCCESS' => Document::where(['certificatelevel'=>'CERTIFIED'] )->count(),
                'COUNT_FAILUR' => Document::where(['certificatelevel'=>'FAILUR'] )->count(),
                "NOT_STAMPED" => Document::where('certificatelevel','<>','CERTIFIED') ->count(),
                "STAMPTING" => Document::where('certificatelevel','=','CERTIFIED')->orderBy('updated_at', 'desc')
                ->paginate(5,['*'],'stemp_page')->setPageName('stemp_page'),
                "NOT_STAMPTING" => Document::where('certificatelevel','<>','CERTIFIED')->orderBy('updated_at', 'desc')
                ->paginate(5,['*'],'nostemp_page')->setPageName('nostemp_page'),
            ];
            return view('admin.dashboard', compact('datas'));

        }else{
            // user
            $datas =[
                'COUNT_DOCUMENT' => NumberHumanizer::metricSuffix(Document::where(['user_id'=> Auth::user()->id])->count()),
                'COUNT_NOT_CERTIFIED' => NumberHumanizer::metricSuffix(Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'NOT_CERTIFIED'] )->count()),
                'COUNT_SUCCESS' => NumberHumanizer::metricSuffix(Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'CERTIFIED'] )->count()),
                'COUNT_FAILUR' => NumberHumanizer::metricSuffix(Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'FAILUR'] )->count()),
                "NOT_STAMPED" => NumberHumanizer::metricSuffix(Document::where('user_id',Auth::user()->id)->where('certificatelevel','<>','CERTIFIED') ->count()),
                "STAMPTING" => Document::where('user_id',Auth::user()->id)->where('certificatelevel','=','CERTIFIED')->orderBy('updated_at', 'desc')
                ->paginate(5,['*'],'stemp_page')->setPageName('stemp_page'),
                "NOT_STAMPTING" => Document::where('user_id',Auth::user()->id)->where('certificatelevel','<>','CERTIFIED')->orderBy('updated_at', 'desc')
                ->paginate(5,['*'],'nostemp_page')->setPageName('nostemp_page'),
            ];
            return view('pages.dashboard', compact('datas'));
        }
        
    }
}
