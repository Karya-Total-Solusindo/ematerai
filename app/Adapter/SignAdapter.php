<?php
namespace App\Adapter;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\Company;
use App\Models\Directory;
use App\Models\Document;

class SignAdapter
{
    /**
     * How to Call this class
     * ================================
     * use App\Adapter\SignAdapter;
     * SignAdapter::class();
     * ==============================
     */
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
    /**
     * disini method generated Batch Serial number
     * 
     */
    public static function getBatchSerial(array $arrayDocumentId){
        // {
        //     "return_url": "https://eoptqh8aqvxplt3.m.pipedream.net",
        //     "tipe":"10000",
        //     "partial":true,
        //     "document": [
        //     {
        //     "idfile": "doc_01",
        //     "file": "dokumen01.pdf",
        //     "namadoc": "4b",
        //     "nodoc": "1",
        //     "tgldoc": "2022-06-04",
        //     "nilaidoc": "150000",
        //     "namejidentitas": "NPWP",
        //     "noidentitas": "1251087201650004",
        //     "namedipungut": "Santoso"
        //     },
        //     {
        //       any data .......     
        //     }
        // }
        $document = Document::whereIn('id',$arrayDocumentId)->get();
        $documents = [];
        foreach ($document as $v) {
            $d =[ 
                "idfile" => $v['id'],
                "file" => $v['filename'],
                "namadoc" => $v['id'],
                "nodoc" => $v['docnumber'],
                "tgldoc" => $v['created_at'], // tanggal pada document
                "nilaidoc" => $v['amount'] ?? 0,
                "namejidentitas" => "NPWP", // dari tabel pemungut
                "noidentitas" => "1251087201650004", // dari tabel pemungut
                "namedipungut" => "Santoso" // dari tabel pemungut
            ];  
            array_push($documents,$d);
        }
        
        // do set data 
        $data = [
            "return_url" => "https://eoptqh8aqvxplt3.m.pipedream.net",
            "tipe" => "10000",
            "partial"=>true,
            'document' => $documents
        ];
        // do generated SN
        $Url = config('sign-adapter.API_GENERATE_SERIAL_NUMBER_BULK');
        $requestAPI = (string) Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . Auth::user()->ematerai_token,
        ])->withBody(json_encode($data))->post($Url);

        $response = json_decode($requestAPI,true);
        if($response['message']=='success'){
            //Set/update Serial Number to database document
            $sn = $response['result']['batchId'];
            $setbachSN = Document::whereIn('id',$arrayDocumentId)->update(['sn'=>$sn ]);
            // dd($setbachSN->getQueryLog());
            return redirect()->route('stemp.index')->with('success',$response['result']['message']);
            // return response()->json($response);
        } 
        return response()->json($response);
        dd($response);
        dd('disini method generatedn bulk Serial number');
    }
}