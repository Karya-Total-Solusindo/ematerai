<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(){
        //return view('pages.dashboard');
        $url = "https://appays.ap1.co.id/webapi/getdocument/barang-dan-jasa/po";
        $response = Http::withHeaders([
            'protocol'=>'2.1',
            'Accept'=>'*/*',
            'User-Agent'=> 'PostmanRuntime/7.33.0',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection'=>'keep-alive',
            'Content-Type'=>'application/json',
        ])->get($url);
        $obj = $response->object();
        // dd($obj->payload);
        echo ($obj->payload->data[0]->title);
        // dd($response->status());
        // dd($response->object());
        // $response = Http::get('https://appays.ap1.co.id/webapi/getdocument/barang-dan-jasa/po');
        //  return response()->json(json_decode($response->getBody(), true));

    }

    public function api(){
        //$apiURLs = Http::acceptJson()->dd()->get('https://appays.ap1.co.id/webapi/getdocument/barang-dan-jasa/po');
        $apiURL = 'https://appays.ap1.co.id/webapi/getdocument/barang-dan-jasa/po';
        //$parameters = ['page' => 2];

        $response = Http::get($apiURL);

        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        return response()->json($responseBody);

        dd($responseBody,$statusCode);

    }
}
