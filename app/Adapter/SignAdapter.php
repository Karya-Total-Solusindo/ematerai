<?php
namespace App\Adapter;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\Company;
use App\Models\Directory;
use App\Models\User;
use App\Models\Document;
use App\Models\Serialnumber;
use Illuminate\Support\Facades\Storage;

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
     * disini method generated sigle Serial number
     * 
     */
    static function getSaldo()
    {
        
    }


    /**
     * disini method generated sigle Serial number
     * 
     */
    public static function getSerial(array $arrayDocumentId){
        // {
        //     "isUpload": false,
        //     "namadoc": "4b",
        //     "namafile": "dok1.pdf",
        //     "nilaidoc": "10000",
        //     "namejidentitas": "KTP",
        //     "noidentitas": "1251087201650003",
        //     "namedipungut": "Santoso",
        //     "snOnly": false,
        //     "nodoc": "1",
        //     "tgldoc": "2022-04-25"
        // }
        $dataArray =[];    
        foreach ($arrayDocumentId as $id) {
            $doc = Document::find($id);
            $desPath = '/docs/'.$doc->company->name.'/'.$doc->directory->name;
            $data = [
                "isUpload"=> false,
                "namadoc"=> "4b",
                "namafile"=>  $doc['filename'],
                "nilaidoc"=> "10000",
                "namejidentitas"=> "KTP",
                "noidentitas"=> "1251087201650003",
                "namedipungut"=> "Santoso",
                "snOnly"=> false,
                "nodoc"=> $doc['docnumber'],
                "tgldoc"=> $doc['created_at']->format('Y-m-d')
            ];
            // do generated SN
            $Url = config('sign-adapter.API_GENERATE_SERIAL_NUMBER');
            $requestAPI = (string) Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . Auth::user()->ematerai_token,
            ])->withBody(json_encode($data))->post($Url);
            $response = json_decode($requestAPI,true);
            $response['data'] = $doc; 
            if($response['statusCode'] == '01'){
                return back()->with($response['message'],$response['result']['err']);
            }
            // return response()->json([$response,$data]);
            if($response['statusCode']=='00'){
                // save serialnumber
                $dataSN =[
                   'sn' => $response['result']['sn'],
                   'image' => $response['result']['image'],
                   'namejidentitas'=> 'KTP',
                   'noidentitas'=> '1251087201650003',
                   'namedipungut'=> 'Santoso',
                   'user_id' => Auth::user()->id,
                   'documet_id' =>  $doc['id'],
                ];
                $SN = Serialnumber::insert($dataSN);
                //Update date Document
                $status = Document::find($id);
                $status->certificatelevel = 'NOT_CERTIFIED';
                $status->sn = $response['result']['sn'];
                $status->x1 = $doc->directory->x1;
                $status->x2 = $doc->directory->x2;
                $status->y1 = $doc->directory->y1;
                $status->y2 = $doc->directory->y2;
                $status->update();                
                $sn = $response['result']['sn'];
                $image = $response['result']['image'];
                $path = $desPath."/spesimen/".$sn.".png";
                Storage::disk('public')->put($path, base64_decode($image));
                Document::where('id', $id)
                ->update(['sn'=>$sn,'spesimenPath' => $desPath."/spesimen/".$sn.".png"]);
            }else{
                //$status = Document::find($id);
                //$status->update();
                //$type = 'application/json';
                //$datas = Document::where(['user_id'=> Auth::user()->id,'id'=>$id])->with('company')->paginate(5);
            }
            array_push($dataArray,$response);
        }
        // $response = json_decode($data,true);
        return back()->with($response['message'],$response['result']['sn']);
        return response()->json($dataArray);
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
        if($response['statusCode'] == '01'){
            return response()->json($response);
        }
        if($response['message']=='success'){
            //Set/update Serial Number to database document
            $sn = $response['result']['batchId'];
            $setbachSN = Document::whereIn('id',$arrayDocumentId)->update(['sn'=>$sn ]);
            // dd($setbachSN->getQueryLog());
            return redirect()->route('stemp.index')->with('success',$response['result']['message']);
            // return response()->json($response);
        } 
        return response()->json($response);
        // dd($response);
        // dd('disini method generatedn bulk Serial number');
    }
}