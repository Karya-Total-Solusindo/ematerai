<?php
namespace App\Adapter;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use App\Models\Company;
use App\Models\Directory;
use App\Models\User;
use App\Models\Document;
use App\Models\Pemungut;
use App\Models\Serialnumber;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

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
    static function setToken($id)
    {
        $data = Document::with('user','company','directory','pemungut')->find($id);
        try{
            $Url = config('sign-adapter.API_LOGIN');
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->withBody(json_encode([
                'user' => $data->pemungut->p_user,
                'password' => Crypt::decrypt($data->pemungut->p_password),
            ]))->post($Url);   
                //$responseC = response($response);
                //$responseC->withCookie(cookie('_token_ematerai',$response['token'], self::$minutes,'/'));
                // return $responseC;
            if($response['message'] == 'success'){ 
                //on table pemungut
                $token = Pemungut::find($data->pemungut->id); 
                $token->token = $response['token'];
                $token->namedipungut = $response['result']['data']['login']['user']['firstName'];
                $token->update();
                //on table user
                $user = User::find($data->user->id); 
                $user->ematerai_token = $response['token'];
                $user->update();
                Log::info("Set Token Success");
                return true;
            }else{
                return false;
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
            $user = Auth::user()->pemungut->token;
            $__token = $user; //self::getToken();
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
        $__token = Auth::user()->ematerai_token;
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
     *  {
     *     "isUpload": false,
     *     "namadoc": "4b",
     *     "namafile": "dok1.pdf",
     *     "nilaidoc": "10000",
     *     "namejidentitas": "KTP",
     *     "noidentitas": "1251087201650003",
     *     "namedipungut": "Santoso",
     *     "snOnly": false,
     *     "nodoc": "1",
     *     "tgldoc": "2022-04-25"
     *  }
     */
    public static function getSerial(array $arrayDocumentId){
        $dataArray =[];    
        foreach ($arrayDocumentId as $id) {
            
            $doc = Document::with('user','company','directory','pemungut')->find($id);
            if($doc==null){
                Log::error('Document Not Exist, id: '.$id);
                return response()->json(['status'=>'error','messega'=>'Document Not Exist'],404);
            }
            Log::info('GET SERIAL NUMBER '.$id.' '.$doc->source);
            $desPath = '/docs/'.strtoupper($doc->company->name).'/'.strtoupper($doc->directory->name);
            $data = [
                "isUpload"=> false, //mand
                "namadoc"=> "4b", //mand
                "namafile"=>  $doc->filename,  //mand
                "nilaidoc"=> "10000", //op
                //"namejidentitas"=>"KTP", //op
                //"noidentitas"=> "1251087201650003", //op
                //"namedipungut"=>"Santoso", //op
                "snOnly"=> false, //mand
                "nodoc"=> $doc->docnumber, //mand
                "tgldoc"=> $doc->created_at->format('Y-m-d') //mand
            ];
            // get jwt Token
            $__token = $doc->user->ematerai_token;
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
                Log::info('SERIAL NUMBER '.__LINE__.' '.$response['result']['err']);
                //return back()->with($response['message'],$response['result']['err']);
            }
            // return response()->json([$response,$data]);
            if($response['statusCode']=='00'){
                // save serialnumber
                $dataSN =[
                   'sn' => $response['result']['sn'],
                   'image' => $response['result']['image'],
                    //'namejidentitas'=> 'KTP',
                    //'noidentitas'=> '1251087201650003',
                    //'namedipungut'=> 'Santoso',
                   'user_id' => $doc->user->id,
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
                Log::info('GET SERIAL NUMBER SUCCESS '.$id.' '.$doc->source);
            }else{
                $status = Document::find($id);
                $status->certificatelevel = 'FAILUR';
                $status->update();
                Log::error('GET SERIAL NUMBER FAILUR');
                //$status = Document::find($id);
                //$status->update();
                //$type = 'application/json';
                //$datas = Document::where(['user_id'=> Auth::user()->id,'id'=>$id])->with('company')->paginate(5);
            }
            array_push($dataArray,$response);
        }
        // $response = json_decode($data,true);
        //return back()->with($response['message'],$response['result']['sn']);
        return response()->json($dataArray);
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
     * @description method ini Tidak Digunakan
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

    /**  
     * check validation accunt by admin
     */
    static function validUser(string $user, string $password)
    {
        try{
            $Url = (string) config('sign-adapter.API_LOGIN');
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->withBody(json_encode([
                'user' =>  $user,
                'password' =>$password,
            ]))->post($Url);   
            $data = json_decode($response);    
            if($response['message'] == 'success'){ 
                return $data;
            }else{
                return $data;
            }
        }catch(\Exception $e){
            return $e;
        }
        
    }
    # ===================================================================
    # Production 
    # ===================================================================
    /**  
     * get user token 
     * @id array id document
     */
    static function getTokenUser(array $id)
    {
        try{
            $documents = Document::with('user','pemungut')->find($id)->first();
            //return response()->json($documents->pemungut->p_password, 200);
            $Url = (string) config('sign-adapter.API_LOGIN');
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->withBody(json_encode([
                'user' =>  $documents->pemungut->p_user,
                'password' => Crypt::decrypt($documents->pemungut->p_password),
            ]))->post($Url);   
            $data = json_decode($response);    
            if($response['message'] == 'success'){ 
                return $data;
            }else{
                return $data;
            }
        }catch(\Exception $e){
            return $e;
        }
    }

    /**
     * TODO: - Get Token Login Peruri 
     * @return 'json data'
     */
    static function getToken(array $id)
    {
        try{
            $documents = Document::with('user','pemungut')->find($id)->first();
            //return response()->json($documents->pemungut->p_password, 200);
            $Url = (string) config('sign-adapter.API_LOGIN');
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->withBody(json_encode([
                'user' =>  $documents->pemungut->p_user,
                'password' => Crypt::decrypt($documents->pemungut->p_password),
            ]))->post($Url);   
            $data = json_decode($response);    
            if($response['message'] == 'success'){ 
                return $data;
            }else{
                return $data;
            }
        }catch(\Exception $e){
            return $e;
        }
    }
    /** 
     * TODO: execusi serial dan lakukan stamp
    */
    public static function exeSreialStamp(array $arrayDocumentId){
        $dataArray =[];
        $dbug =[];
       try{
             // check token user documen 
             // do generated SN
            $__token = '';
            $Url = config('sign-adapter.API_STEMPTING');
            foreach ($arrayDocumentId as $id) {
                $datas = Document::with('user','company','directory','pemungut')->find($id);
                $relativePathIn = $datas->company->name.'/'.$datas->directory->name.'/in/'.$datas->filename;
                $relativePathBackup = $datas->company->name.'/'.$datas->directory->name.'/backup/'.$id.'_BACKUP_'.$datas->filename;
                //return response()->json($datas); 
                if($datas->sn ==''){
                    //TODO - getSerial()
                    Log::info('STAMP GET SN: '.$datas->id.' '.$datas->source);
                    return self::getSerial([$datas->id]);
                }
                if($datas->user->ematerai_token!=null){
                    $__token = $datas->user->ematerai_token;
                }else{
                    $__token = (self::setToken($datas->id))? $datas->user->ematerai_token:$datas->pemungut->token;
                }
                $dbug =[
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
                ];
                
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
                                if(Storage::disk('document')->move($relativePathIn,$relativePathBackup)){
                                    $status = Document::find($id);
                                    $status->certificatelevel = 'CERTIFIED';
                                    $status->update();
                                    $serialUsed = Serialnumber::where('sn','=',$datas->sn);
                                    $serialUsed->use = '1';
                                    $serialUsed->useby = Auth::user()->email;
                                    $serialUsed->update();
                                }
                                Log::info('Move IN backup '.$relativePathIn.' to '.$relativePathBackup);
                                //Storage::disk('document')->move($relativePathIn,$relativePathBackup);
                            }else{
                                $status = Document::find($id);
                                $status->certificatelevel = 'FAILUR';
                                $status->message = $response['errorMessage'];
                                $status->update();
                                Log::error('STAMPE FAILUR: '.$id);
                            }
                            array_push($dataArray,$response);
                            // return json_encode($response);
            }
            return response()->json([$dataArray,$dbug]);    
        }catch(\GuzzleHttp\Exception\RequestException $e){
            // you can catch here 40X re
            // sponse errors and 500 response errors
            Log::error($e->getMessage());
            return back()->with($e,'500 response errors');
        }   
        return back()->with($response['message'],'Success');
    }

    /*TODO -  API Generate QR Image
    *
    */
    public static function generatedQRImage(string $sn){
        try{
            //$documents = Document::with('user','pemungut')->find($id)->first();
            //return response()->json($documents->pemungut->p_password, 200);
            $Url = (string) config('sign-adapter.API_GENERATE_QR');
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . Auth::user()->ematerai_token,
            ])->withBody(json_encode([
                'serialnumber' => $sn,
                'onprem' => true,
            ]))->get($Url);   
            $data = json_decode($response); 
            dd($sn,$Url,$data);   
            if($response['message'] == 'success'){ 
                return $data;
            }else{
                return $data;
            }
        }catch(\Exception $e){
            return $e;
        }
    }

}