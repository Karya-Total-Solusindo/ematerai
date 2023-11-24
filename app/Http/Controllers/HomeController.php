<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Directory;
use App\Models\Document;
use App\Models\User;

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
        $datas =[
            'COUNT_DOCUMENT' => Document::where(['user_id'=> Auth::user()->id])->count(),
            'COUNT_NOT_CERTIFIED' => Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'NOT_CERTIFIED'] )->count(),
            'COUNT_SUCCESS' => Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'CERTIFIED'] )->count(),
            'COUNT_FAILUR' => Document::where(['user_id'=> Auth::user()->id,'certificatelevel'=>'FAILUR'] )->count(),
            "NOT_STAMPED" => Document::where('user_id',Auth::user()->id)->where('certificatelevel','<>','CERTIFIED') ->count(),
            "STAMPTING" => Document::where('user_id',Auth::user()->id)->where('certificatelevel','=','CERTIFIED')->orderBy('updated_at', 'desc')
            ->paginate(5,['*'],'stemp_page')->setPageName('stemp_page'),
            "NOT_STAMPTING" => Document::where('user_id',Auth::user()->id)->where('certificatelevel','<>','CERTIFIED')->orderBy('updated_at', 'desc')
            ->paginate(5,['*'],'nostemp_page')->setPageName('nostemp_page'),
        ];
        return view('pages.dashboard', compact('datas'));
    }
}
