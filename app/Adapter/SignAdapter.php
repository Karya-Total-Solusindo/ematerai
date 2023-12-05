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

/** NOTE - SignAdapter
 *  
 * @config sing-adapter.php
 * @url list of url on sing-adapter.php
 */
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
        try{
            $Url = config('sign-adapter.API_LOGIN');
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->withBody(json_encode([
                'user' => env('EMATRERAI_USER'),
                'password' => env('EMATRERAI_PASSWORD'),
            ]))->post($Url);   
                //$responseC = response($response);
                //$responseC->withCookie(cookie('_token_ematerai',$response['token'], self::$minutes,'/'));
                // return $responseC;
            if($response['message'] == 'success'){ 
                return $response['token'];
            }else{
                return $response['message'];
            }
        }catch(\Exception $e){
            return $e;
        }
        
    }

    /**
     * API Jenis Document digunakan untuk mendapatkan 
     * list jenis dokumen yang digunakan untuk
     * mengisi parameter “namadoc” saat melakukan generate SN.
     * @return json id, kode, nama
     */
    public static function getJenisDocument()
    {
        try{
            $__token = self::getToken();
            $Url = config('sign-adapter.API_JENIS_DOCUMENT');
            $requestAPI = (string) Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $__token,
            ])->get($Url);
            $response = json_decode($requestAPI,true);
        }catch(\Exception $e){
            return $e;
        }
        if($response['statusCode']=='00'){
            return $response['result']; // response()->json($response['result']);
        }else{
            $data =[  
                [
                    "id" => "4e9de1e8-879e-4bd3-a681-704afd6fd84b",
                    "kode" => "3",
                    "nama" => "Surat Keterangan",
                ],
                [
                    "id" => "8ee8bdec-5ddf-4797-a74c-fd45977513c9",
                    "kode" => "4a",
                    "nama" => "Dokumen penerimaan uang (lebih dari 5 juta)",
                ],
                [
                    "id" => "6a004c92-739d-4325-ab88-873d11d592a0",
                    "kode" => "3",
                    "nama" => "Surat Lainnya",
                ],
                [
                    "id" => "5ab5ff9d-3fc0-452a-b63a-f78c021de06f",
                    "kode" => "3",
                    "nama" => "Surat Pernyataan",
                ],
                [
                    "id" => "3e05283e-e98b-41b7-a3cc-8ae9d3cda2b5",
                    "kode" => "2",
                    "nama" => "Dokumen Transaksi",
                ],
                [
                    "id" => "14bb5e08-3745-40de-b4ce-122a75ae09aa",
                    "kode" => "4b",
                    "nama" => "Dokumen pelunasan utang (lebih dari 5 juta)",
                ],
                [
                    "id" => "8cf53120-3c28-496f-920f-aed7e587856f",
                    "kode" => "2",
                    "nama" => "Surat Berharga",
                ],
                [
                    "id" => "d25e6e2f-ef10-44c2-941f-7e77beff2818",
                    "kode" => "2",
                    "nama" => "Akta Pejabat",
                ],
                [
                    "id" => "8cf53120-3c28-496f-920f-aed7e587856e",
                    "kode" => "2",
                    "nama" => "Dokumen lain-lain",
                ],
                [
                    "id" => "8ee8bdec-5ddf-4797-a74c-fd45977513c8",
                    "kode" => "2",
                    "nama" => "Akta Notaris",
                ],
                [
                    "id" => "6a004c92-739d-4325-ab88-873d11d592a1",
                    "kode" => "2",
                    "nama" => "Dokumen Lelang",
                ],
                [
                    "id" => "3e05283e-e98b-41b7-a3cc-8ae9d3cda2b4",
                    "kode" => "3",
                    "nama" => "Surat Perjanjian",
                ],
                [
                    "id" => "3e05283e-e98b-41b7-a3cc-8ae9d3cda2b7",
                    "kode" => "4a",
                    "nama" => "Dokumen pernyataan jumlah uang lebih dari 5jt",
                ]
            ];
            return response()->json($response['message']);
        }
    }

    /**
     * disini method generated sigle Serial number
     * 
     */
    public static function getSaldo()
    {
       return 'saldo';
    }

    /** 
     * Check Serial Number Ematerai
     * @url sign-adapter.API_CHECK_SERIAL_NUMBER
     * @return $return = true as json
     * @return $return = false as boolean
    */
    public static function getCheckSN(string $serialnumber, bool $return = true){
        $__token = self::getToken();
        $data = [
            'filter' => $serialnumber,
        ];
        $Url = config('sign-adapter.API_CHECK_SERIAL_NUMBER');
        $requestAPI = (string) Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $__token,
        ])->withBody(json_encode($data))->get($Url);
        $response = json_decode($requestAPI,true);
        if($return){
            if($response['statusCode']=='00'){
                return response()->json($response['result']['data']);
            }else{
                return response()->json($response['message']);
            }
        }else{
            return false;
        }
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
            if($doc->sn ==''){
            
            }
            $desPath = '/docs/'.strtoupper($doc->company->name).'/'.strtoupper($doc->directory->name);
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
            // get jwt Token
            $__token = self::getToken();
            // do generated SN
            $Url = config('sign-adapter.API_GENERATE_SERIAL_NUMBER');
            $requestAPI = (string) Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $__token,
            ])->withBody(json_encode($data))->post($Url);
            $response = json_decode($requestAPI,true);
            $response['data'] = $doc; 
            if($response['statusCode'] != '00'){
                Document::where('id', $id)
                ->update(['message'=>$response['result']['err']]);
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
                   'user_id' => 0,
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
                $status = Document::find($id);
                $status->certificatelevel = 'FAILUR';
                $status->update();
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
     * execusi serial dan lakukan stamp
    */
    public static function exeSreialStamp(array $arrayDocumentId){
        $dataArray =[];
        try{
             // do generated SN
             $__token = '';
             if(isset(Auth::user()->ematerai_token)){
                 $__token = Auth::user()->ematerai_token;
             }else{
                 $__token =  self::getToken();
             }
            $Url = config('sign-adapter.API_STEMPTING');
            foreach ($arrayDocumentId as $id) {
            $serialdata = Document::find($id);
            if($serialdata->sn ==''){
               self::getSerial([$id]);
            }
            $datas = Document::find($id);
            $stemting = (string) Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $__token,
                ])->withBody(json_encode([
                    "certificatelevel"=> "NOT_CERTIFIED",
                    'dest'=>  '/sharefolder/docs/'.$datas->company->name.'/'.$datas->directory->name.'/out/'.$datas->filename, 
                    "docpass"=> "",
                    "jwToken"=> $__token,
                    "location"=> "JAKARTA",
                    "profileName"=> "emeteraicertificateSigner",
                    "reason"=> "Ematerai Farpoint",
                    "refToken"=> $datas->sn,
                    "spesimenPath"=> '/sharefolder/docs/'.$datas->company->name.'/'.$datas->directory->name.'/spesimen/'.$datas->sn.'.png',//"{{fileQr}}",
                    "src"=> '/sharefolder/docs/'.$datas->company->name.'/'.$datas->directory->name.'/in/'.$datas->filename,
                    'visLLX'=> $datas->x1, //$input['lower_left_x'] ?? '0',
                    'visLLY'=> $datas->y1, //$input['lower_left_y'] ?? '0',
                    'visURX'=> $datas->x2, //$input['upper_right_x'] ?? '0',
                    'visURY'=> $datas->y2, //$input['upper_right_y'] ?? '0',
                    'visSignaturePage' => $datas->page, //$input['dokumen_page'] ?? '0',
                ]))->post($Url)->getBody();
                $response = json_decode($stemting,true);
                    //Update status document jika stemting berhasil berhasil
                        if($response['status']=='True'){
                            $status = Document::find($id);
                            $status->certificatelevel = 'CERTIFIED';
                            $status->update();
                        }else{
                            $status = Document::find($id);
                            $status->certificatelevel = 'FAILUR';
                            $status->message = $response['errorMessage'];
                            $status->update();
                        }
                        array_push($dataArray,$response);
                        // return json_encode($response);
                }
                return response()->json($dataArray);    
            }catch(\GuzzleHttp\Exception\RequestException $e){
            // you can catch here 40X re
            // sponse errors and 500 response errors
                return back()->with($response['message'],'500 response errors');
            }   
            return back()->with($response['message'],'Success');
    }


     // lemparan STEMTING
        /*
         {
            "certificatelevel": "NOT_CERTIFIED",
            "dest": "{{fileStamp}}",  // simpan disini setelah distemting
            "docpass": "",
            "jwToken": "{{token}}",
            "location": "JAKARTA",
            "profileName": "emeteraicertificateSigner",
            "reason": "Akta Pejabat",
            "refToken": "{{serialNumber}}",
            "spesimenPath": "{{fileQr}}",
            "src": "{{file}}", //sumber file 
            "visLLX": 237,
            "visLLY": 559,
            "visURX": 337,
            "visURY": 459,
            "visSignaturePage": 1
        } 
         */
        //harusnya ambil dari database





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