<?php

namespace App\Http\Controllers;

use App\Adapter\SignAdapter;
use App\Models\Company;
use App\Models\Directory;
use App\Models\Document;
use App\Models\User;
use App\Models\Serialnumber;
// use GuzzleHttp\Psr7\Uri;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
//excel
use App\Exports\ExportDocumentSuccess;
use App\Exports\ExportDocumentSuccessView;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;

class StempController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user()->id;
        if (($s = $request->s)) {
            $datas =  Document::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('filename', 'LIKE', '%' . $s . '%')
                        ->Where('user_id','=',Auth::user()->id)
                        ->orderBy('created_at', 'desc')
                            ->get();
                    }
                }]
            ])->with('company')->orderBy('created_at', 'desc')->paginate(50);
        }else{
            $datas =  Document::with('company')->where('user_id','=',Auth::user()->id)->orderBy('created_at', 'desc')->paginate(50);
        }
        return view("client.stemp.index", compact("datas"));
    }

    public function company(Request $request)
    {
        $user = Auth::user()->id;
        $datas = Company::where(['user_id'=>$user])->paginate(50);
        if (($s = $request->s)) {
            $datas = Company::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $user = Auth::user()->id;
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->Where('user_id', $user)
                        ->orderBy('created_at', 'desc')
                        ->get();
                    }
                }]
                ])->orderBy('created_at', 'desc')->paginate(50);
        }
        return view("client.stemp.index", compact("datas"));
    }
    public function directory($company_id, Request $request)
    {
        $user = Auth::user()->id;
        $request['company'] = $company_id;
        $datas = Directory::where(['user_id'=>$user,'company_id'=> $company_id])->paginate(50);
        if (($s = $request->s)) {
            $datas = Directory::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $user = Auth::user()->id;
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->orWhere('sn', 'LIKE', '%' . $s . '%')
                        ->Where('user_id', $user)
                        ->Where('company_id', $request->company)
                        ->orderBy('update_at', 'desc')
                        ->get();
                    }
                }]
                ])->orderBy('update_at', 'desc')->paginate(50);
        }
        $company = Company::find(['id'=>$company_id])->where(['user_id'=>$user])->first();
        if ($company) {
            return view("client.stemp.index", compact(["datas","company"]));
        }
        return redirect()->route('home')->with('error', 'Directory not found!');
       
    }
    public function document($directory_id, Request $request)
    {
        $user = Auth::user()->id;
        $request['directory_id'] = $directory_id;
        $datas = Document::where(['user_id'=>$user,'directory_id'=> $directory_id])
        ->Where('certificatelevel','<>', 'CERTIFIED')
        ->Where('certificatelevel','<>', 'INPROGRESS')
        ->Where('certificatelevel','<>', 'HISTORY')
        ->Where('certificatelevel','<>', 'DELETED')
        ->orderBy('updated_at', 'desc')->paginate(50);
        if (($s = $request->s)) {
            $datas = Document::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $user = Auth::user()->id;
                        $query
                        ->orWhere('filename', 'LIKE', '%' . $s . '%')
                        ->orWhere('sn', 'LIKE', '%' . $s . '%')
                        ->orderBy('updated_at', 'desc')
                        ->get();
                    }
                }]
                ])
                ->Where('user_id', $user)
                ->Where('directory_id', $request->directory_id)
                ->Where('certificatelevel','<>', 'CERTIFIED')
                ->Where('certificatelevel','<>', 'INPROGRESS')
                ->Where('certificatelevel','<>', 'HISTORY')
                ->Where('certificatelevel','<>', 'DELETED')
                ->orderBy('updated_at', 'desc')->paginate(10);
        }
        $directory = Directory::find(['id',$directory_id])->where('user_id',$user)->first();
        if($directory){
            return view("client.stemp.index", compact("datas","directory"));
        }
        return redirect()->route('company')->with('error', 'Directory not found!');
    }

    public function addfile(Directory $directory){
        if(Auth::user()->ematerai_token){
            if(env('APP_DEBUG')=='true'){
                //echo Auth::user()->ematerai_token;
                //session(['success' => env('APP_DEBUG')." ".Auth::user()->ematerai_token]);
            }
        } 
        $datas = Directory::with('company')->find($directory->id)->where('id',$directory->id)->get();
        // Company::with('directory')->find($directory->id);
        return view("client.stemp.index", compact("datas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("client.stemp.index");
        // return view("client.stemp.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);
        $input = $request->all();
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();  // str_replace(' ','_',time().'_'.$file->getClientOriginalName());
        $filePath = 'docs/'.$input['company_name'].'/'.$input['directory_name'].'/in/'.$fileName;
        Storage::disk('public')->makeDirectory('docs/'.$input['company_name'].'/'.$input['directory_name'].'/in/');
        $path = Storage::disk('public')->put($filePath,file_get_contents($request->file));
        $companyId = $input['company'];
        $user = Auth::user()->id;
        $uniq = [
            // 'active'=> 1,
        ];
        // get serial number
        // {
        //     "isUpload": false,
        //     "namadoc": "4b",
        //     "namafile": "{{namafile}}",
        //     "nilaidoc": "10000",
        //     "namejidentitas": "KTP",
        //     "noidentitas": "1251038765430004",
        //     "namedipungut": "Santosa",
        //     "snOnly": false,
        //     "nodoc": "25",
        //     "tgldoc": "2022-02-20"
        // }
        
        //do Upload Files
        $desPath = '/docs/'.$input['company_name'].'/'.$input['directory_name'];
        $data = [ 
            'certificatelevel'=>'NOT_CERTIFIED',
            'user_id'=>  $user,
            'company_id'=>  $companyId,
            'directory_id'=> $input['directory'],
            'active'=> 1,
            'docnumber' => $input['docnumber'],
            'source'=> '/docs/'.$input['company_name'].'/'.$input['directory_name'].'/in/'.$fileName ?? '0',
            'x1'=> $input['x1'] ?? '0',
            'x2'=> $input['x2'] ?? '0',
            'y1'=> $input['y1'] ?? '0',
            'y2'=> $input['y2'] ?? '0',
            'height' => $input['dokumen_height'] ?? '0',
            'width' => $input['dokumen_width'] ?? '0',
            'page' => $input['dokumen_page'] ?? '0',
            'filename' => $input['filename'] ?? '0',
        ];
        $fileUpload =  Document::Create($data);
        $fileUpload->filename = $fileName;
        $fileUpload->save();
        // get serial number
        $Url = config('sign-adapter.API_GENERATE_SERIAL_NUMBER');
        // dd($Url);
        $getSerialNumber = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . Auth::user()->ematerai_token,
        ])->withBody(json_encode([
            "isUpload" => false,
            "namadoc"=> "4b",
            "namafile"=> $fileName,
            "nilaidoc"=> "10000",
            "namejidentitas"=> "KTP",
            "noidentitas"=> "1251038765430004",
            "namedipungut"=> "Santosa",
            "snOnly"=> false,
            "nodoc"=> "25",
            "tgldoc"=> "2022-02-20"
        ]))->post($Url);

        $token = new SignAdapter;
        if($getSerialNumber['statusCode'] == '01'){
            $token = new SignAdapter;
            $token->getToken();
        }else{
            $sn = $getSerialNumber['result']['sn'];
            $image = $getSerialNumber['result']['image'];
            $path = $desPath."/spesimen/".$sn.".png";
            Storage::disk('public')->put($path, base64_decode($image));
            Document::where('id',$fileUpload->id)
            ->update(['sn'=>$sn,'spesimenPath' => $desPath."/spesimen/".$sn.".png"]);
            
            $dataSN =[
                'sn' => $getSerialNumber['result']['sn'],
                'image' => $getSerialNumber['result']['image'],
                'namejidentitas'=> 'KTP',
                'noidentitas'=> '1251087201650003',
                'namedipungut'=> 'Santoso',
                'user_id' => Auth::user()->id,
                'documet_id' =>  $fileUpload->id,
             ];
             $SN = Serialnumber::insert($dataSN);
        }
        // echo $getSerialNumber['statusCode'];
        // echo $getSerialNumber['message'];

        $result = response()->json(['success'=>$fileName,
        'detail'=>[
            'company'=>$input['company_name'],
            'directory'=>$input['directory_name'],
            'file'=>$desPath,
            'template'=> 'file'
            ]
        ]);
        
        $dir = $input['directory'] ?? '0';
        return redirect()->route('document', $dir)->with('success', 'The file has been uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datas = Document::where(['user_id'=> Auth::user()->id,'id'=>$id]);
        if($datas->count() == 0){
            return redirect()->route('stemp.index')->with('success','No data');
        } 
        $datas = $datas->get(); 
        return view('client.stemp.index', compact('datas'));
    }

   /**
     * Show the form for editing the specified resource.
     */
    public function process(string $id)
    {
        $datas = Document::where(['id'=> $id, 'user_id'=> Auth::user()->id])->first();
        if($datas){
            return view('client.stemp.stemp', compact('datas'));
        }
        return redirect()->to('/')->withErrors(['error', 'Data Not Found!'])->with('error', 'Data Not Found!');
    }


    public function stemp(Request $request)
    {
        $valid = $request->validate([
            'lower_left_x' =>'required',
            'lower_left_y' =>'required',
            'upper_right_x' =>'required',
            'upper_right_y' =>'required',
            'dokumen_page' =>'required',
        ]);

        $input = $request->all();
        $headers =[];
        $user = Auth::user()->id;
        $id = $input['id'];
        $datas = Document::where(['user_id'=> Auth::user()->id,'id'=>$id])->first();
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

        $dataApp=[
             // data app 
             'id' => $id,
             'user_id'=>  $user,
             'company_id'=>  $input['company'],
             'directory_id'=> $input['directory'],
             'active'=> 1,
             'docnumber' => $input['docnumber'],
             // 'source'=> '/docs/'.$input['company_name'].'/'.$input['directory_name'].'/in/'.$fileName ?? '0',
             'height' => $input['dokumen_height'] ?? '0',
             'width' => $input['dokumen_width'] ?? '0',
             'filename' => $input['filename'] ?? '0',
             '_token_ematerai' => Cookie::get('_token_ematerai'),
        ];

        $Url = config('sign-adapter.API_STEMPTING');
        // echo $Url; 
        // echo Auth::user()->ematerai_token;
        // return response()->json($Url, 200, $headers);
        try{
            $stemting = (string) Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . Auth::user()->ematerai_token,
                ])->withBody(json_encode([
                    "certificatelevel"=> "NOT_CERTIFIED",
                    'dest'=>  '/sharefolder/docs/'.$datas->company->name.'/'.$datas->directory->name.'/out/'.$datas->filename, 
                    "docpass"=> "",
                    "jwToken"=> Auth::user()->ematerai_token,
                    "location"=> "JAKARTA",
                    "profileName"=> "emeteraicertificateSigner",
                    "reason"=> "Ematerai Farpoint",
                    "refToken"=> $datas->sn,
                    "spesimenPath"=> '/sharefolder/docs/'.$datas->company->name.'/'.$datas->directory->name.'/spesimen/'.$datas->sn.'.png',//"{{fileQr}}",
                    "src"=> '/sharefolder/docs/'.$datas->company->name.'/'.$datas->directory->name.'/in/'.$datas->filename,
                    'visLLX'=> $input['lower_left_x'] ?? '0',
                    'visLLY'=> $input['lower_left_y'] ?? '0',
                    'visURX'=> $input['upper_right_x'] ?? '0',
                    'visURY'=> $input['upper_right_y'] ?? '0',
                    'visSignaturePage' => $input['dokumen_page'] ?? '0',
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
                            $status->update();
                            $type = 'application/json';
                            $datas = Document::where(['user_id'=> Auth::user()->id,'id'=>$id])->with('company')->paginate(50);
                        }
                    return json_encode($response);
            }catch(\GuzzleHttp\Exception\RequestException $e){
            // you can catch here 40X response errors and 500 response errors
             
            }      
    }
    public function progress(Request $request)
    {
        $user = Auth::user()->id;
        if (($s = $request->s)) {
            $datas =  Document::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('filename', 'LIKE', '%' . $s . '%')
                        ->Where('certificatelevel','=','INPROGRESS')
                        ->Where('user_id','=',Auth::user()->id)
                        ->orderBy('updated_at', 'desc')
                            ->get();
                    }
                }]
            ])->with('company')->orderBy('updated_at', 'desc')->paginate(50);
        }else{
            $datas =  Document::with('company')
            ->where('user_id','=',Auth::user()->id)
            ->where('certificatelevel','=','INPROGRESS')
            ->orderBy('updated_at', 'desc')
            ->paginate(50);
        }
        return view("client.stemp.index", compact("datas"));
    }

     /**
     * List Success Stemp.
     */
    public function failed(Request $request)
    {
        $user = Auth::user()->id;
        if (($s = $request->s)) {
            $datas =  Document::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('filename', 'LIKE', '%' . $s . '%')
                        ->Where('certificatelevel','=','FAILUR')
                        ->Where('user_id','=',Auth::user()->id)
                        ->orderBy('updated_at', 'desc')
                            ->get();
                    }
                }]
            ])->with('company')->orderBy('updated_at', 'desc')->paginate(50);
        }else{
            $datas =  Document::with('company')
            ->where('user_id','=',Auth::user()->id)
            ->where('certificatelevel','=','FAILUR')
            ->orderBy('updated_at', 'desc')
            ->paginate(50);
        }
        return view("client.stemp.index", compact("datas"));
    }


    /**
     * List Success Stemp.
     * TODO SUCCESS
     */
    public function success(Request $request)
    {
        $company = null;
        $directory = null;
        if($request->getRequestUri()){
                $company = $request->input('company');
                $directory = $request->input('directory');
        }
        $user = Auth::user()->id;
        if (($s = $request->s)) {
            $datas =  Document::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('filename', 'LIKE', '%' . $s . '%')
                        ->Where('certificatelevel','=','CERTIFIED')
                        ->Where('user_id','=',Auth::user()->id)
                        ->orderBy('updated_at', 'desc')
                            ->get();
                    }
                }]
            ])->with('company')->orderBy('updated_at', 'desc')->paginate(50);
            return view("client.stemp.index", compact("datas","company","directory"));
        }
        if($c = $request->company || $d = $request->directory || $r = $request->periode) {
            $splitdate = explode('-',$request->periode);
            $dateStart = date('Y-m-d', strtotime($splitdate[0]));
            $dateEnd = date('Y-m-d', strtotime($splitdate[1]));
            dd($c = $request->company, $d = $request->directory, $r = $request->periode,$dateStart,$dateEnd,$splitdate);
            // dd('filter');
            //filter company directory daterange
            $datas =  Document::where([
                [function ($query) use ($request) {
                    if ($c = $request->company || $d = $request->directory) {
                        $d = $request->directory;
                        $query->Where('company_id','=',$c)
                        ->Where('directory_id','=',$d)
                        ->Where('certificatelevel','=','CERTIFIED')
                        ->Where('user_id','=',Auth::user()->id)
                        ->orderBy('updated_at', 'desc')
                            ->get();
                    }
                }]
            ])->with('company')->orderBy('updated_at', 'desc')->paginate(50);
            return view("client.stemp.index", compact("datas","company","directory"));
        }
       
            $datas =  Document::with('company')
            ->where('user_id','=',Auth::user()->id)
            ->where('certificatelevel','=','CERTIFIED')
            ->orderBy('updated_at', 'desc')
            ->paginate(50);
        
            return view("client.stemp.index", compact("datas","company","directory"));
    }

    /**
     * List history Stemp.
     * todo history
     */
    public function history(Request $request)
    {
        $company = null;
        $directory = null;
        if($request->getRequestUri()){
                $company = $request->input('company');
                $directory = $request->input('directory');
        }
        $user = Auth::user()->id;
        if (($s = $request->s)) {
            $datas =  Document::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('filename', 'LIKE', '%' . $s . '%')
                        ->Where('certificatelevel','=','HISTORY')
                        ->Where('user_id','=',Auth::user()->id)
                        ->orderBy('updated_at', 'desc')
                            ->get();
                    }
                }]
            ])->with('company')->orderBy('updated_at', 'desc')->paginate(50);
            return view("client.stemp.index", compact("datas","company","directory"));
        }
        if($c = $request->company || $d = $request->directory || $r = $request->periode) {
            // dd($c = $request->company, $d = $request->directory, $r = $request->periode);
            // dd('filter');
            //filter company directory daterange
            $datas =  Document::where([
                [function ($query) use ($request) {
                    if ($c = $request->company || $d = $request->directory) {
                        $d = $request->directory;
                        $query->Where('company_id','=',$c)
                        ->Where('directory_id','=',$d)
                        ->Where('certificatelevel','=','HISTORY')
                        ->Where('user_id','=',Auth::user()->id)
                        ->orderBy('updated_at', 'desc')
                            ->get();
                    }
                }]
            ])->with('company')->orderBy('updated_at', 'desc')->paginate(50);
            return view("client.stemp.index", compact("datas","company","directory"));
        }
       
            $datas =  Document::with('company')
            ->where('user_id','=',Auth::user()->id)
            ->where('certificatelevel','=','HISTORY')
            ->orderBy('updated_at', 'desc')
            ->paginate(50);
                $company = null;
                $directory = null;
            if($request->getRequestUri()){
                    $company = $request->input('company');
                    $directory = $request->input('directory');
            }
            return view("client.stemp.index", compact("datas","company","directory"));
    }

    // ditampilkan ke modal view
    public function _modalProcess(Request $request)
    {
        $id =1;
        $datas = Document::where(['user_id'=> Auth::user()->id,'id'=>$id])->first();
        return response()
            ->view('client.stemp.stemp', compact('datas'), 200)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

        /**TODO Status Success Export Excel - 
         * 
         */
       public function exportSuccecc(Request $request) 
        {
            $url = $request->Query();
            $status = (isset($url['status']))? ['certificatelevel'=>strtoupper($url['status'])]:'CERTIFIED';
            $status_text = (isset($url['status']))? $url['status']:null;
            $year = (isset($url['year']))? $url['status']:null;
            $month = (isset($url['month']))? $url['status']:null;
            $day = (isset($url['day']))? $url['status']:null;
            // dd($url);
            return   Excel::download(new ExportDocumentSuccess($status,$year,$month,$day), date('Y_m_d').'_Ematerai_Document_Stamp_'.$status_text.'.xlsx',\Maatwebsite\Excel\Excel::XLSX);
        }



        public function stampDetail(string $sn){
           return SignAdapter::getCheckSN($sn, true);
           
        }


        // public function downloadOne(){
        //     $zip_file = date('YmdHis').'_ematerai.zip'; // Name of our archive to download

        //     // Initializing PHP class
        //     $zip = new \ZipArchive();
        //     $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        //     $invoice_file = 'invoices/aaa001.pdf';

        //     // Adding file: second parameter is what will the path inside of the archive
        //     // So it will create another folder called "storage/" inside ZIP, and put the file there.
        //     $zip->addFile(storage_path($invoice_file), $invoice_file);
        //     $zip->close();

        //     // We return the file immediately after download
        //     return response()->download($zip_file);
        //}
      
        /**TODO - download
         * Select array id document to download
         * and update ststus SUCCESS_DOWNLOAD to show menu history
         */
        public function download(Request $request){
            $dir_id = $request->doc;
            $all = Document::whereIn('id',$dir_id)->where('user_id','=',Auth::user()->id)->get();
            $explode = explode('/',$all);
           
            $company = str_replace('\\','',$explode[2]);
            $document = str_replace('\\','',$explode[3]);
            $zip_file = str_replace(' ','_','ematerai_'.date('YmdHis').'_'.$company.'_'.$document.'.zip'); // Name of our archive to download
            
            $zip = new \ZipArchive();
            $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $_DIRECTORY = 'app/public/docs/'.$company.'/'.$document.'/out/';
            //$RESULT_DIRECTORY=  $company.'/'.$document.'/';
            $path = storage_path($_DIRECTORY);
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
           foreach($all as $doc){
               foreach ($files as $name => $file)
               {
                   if (!$file->isDir()) {
                       $filePath     = $file->getRealPath();
   
                       // extracting filename with substr/strlen
                       // $relativePath = 'company/' . substr($filePath, strlen($path) + 1);
                       $relativePath = $company.'/'.$document.'/' . substr($filePath, strlen($path) + 1);
                       // $notrelativePath = 'company/' . substr($filePath, strlen($path) + 1);
                       // $notrelativePath = $_DIRECTORY . substr($filePath, strlen($path) + 1);
                       // dd($filePath,$file->getfilename(),$doc->filename);
                       if($file->getfilename()==$doc->filename){
                           $zip->addFile($filePath, $relativePath);
                            //update status setelahdidownload
                            $status = Document::find($doc->id);
                            //if success stem and download
                            $status->certificatelevel = 'HISTORY'; 
                            $status->message = $zip_file;
                            $status->update();
                       }
                       // $zip->addFile($filePath, $notrelativePath);
                   }
               }
           }
            $zip->close();
            return response()->download($zip_file);
        }

        public function trash(Request $request)
        {
            $id = $request->doc;
            //get post by ID
            $document = Document::findOrFail($id)->where('user_id','=',Auth::user()->id);
            foreach($document as $doc){
                // dd($doc->source,$doc->company->name,$doc->directory->name);
                $status = Document::find($doc->id);
                $status->certificatelevel = 'DELETED'; 
                // $status->message = $zip_file;
                $status->update();
                //delete file
                Storage::delete(storage_path('app/public/doc/'.$doc->company->name.'/'.$doc->directory.'/out/'. $doc->filename));
                // dd(storage_path('app/public/doc/'.$doc->company->name.'/'.$doc->directory->name.'/out/'. $doc->filename));
            }
            //delete image
            //Storage::delete('public/posts/'. $doc->image);

            //delete doc
            //$doc->delete();

            //redirect to index
            return redirect()->route('history')->with(['success' => 'Data Berhasil Dihapus!']);
            //$all = Document::whereIn('id',$dir_id)->where('user_id','=',Auth::user()->id)->get();
        }

}
