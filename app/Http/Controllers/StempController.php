<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Directory;
use App\Models\Document;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Http;
use App\Adapter\SignAdapter;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


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
                            ->get();
                    }
                }]
            ])->with('company')->paginate(5);
        }else{
            $datas =  Document::with('company')->where('user_id','=',Auth::user()->id)->paginate(5);
        }
        return view("client.stemp.index", compact("datas"));
    }

    public function company(Request $request)
    {
        $user = Auth::user()->id;
        $datas = Company::where(['user_id'=>$user])->paginate(5);
        if (($s = $request->s)) {
            $datas = Company::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $user = Auth::user()->id;
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->Where('user_id', $user)
                        ->get();
                    }
                }]
                ])->paginate(5);
        }
        return view("client.stemp.index", compact("datas"));
    }
    public function directory($company_id, Request $request)
    {
        $user = Auth::user()->id;
        $request['company'] = $company_id;
        $datas = Directory::where(['user_id'=>$user,'company_id'=> $company_id])->paginate(5);
        if (($s = $request->s)) {
            $datas = Directory::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $user = Auth::user()->id;
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->Where('user_id', $user)
                        ->Where('company_id', $request->company)
                        ->get();
                    }
                }]
                ])->paginate(5);
        }
        $company = Directory::with('company_id',$company_id);
        return view("client.stemp.index", compact(["datas","company"]));
    }
    public function document($directory_id, Request $request)
    {
        $user = Auth::user()->id;
        $request['company'] = $directory_id;
        $datas = Document::where(['user_id'=>$user,'directory_id'=> $directory_id])->paginate(5);
        if (($s = $request->s)) {
            $datas = Document::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $user = Auth::user()->id;
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->Where('user_id', $user)
                        ->Where('directory_id', $request->company)
                        ->get();
                    }
                }]
                ])->paginate(5);
        }
        return view("client.stemp.index", compact("datas"));
    }

    public function addfile(Directory $directory){
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
        $path = Storage::disk('public')->put($filePath,file_get_contents($request->file));
        // $path = Storage::disk('public')->url($path);
        // $file->move(public_path($path),$fileName);
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
        // $datas = Document::where(['id'=> $id, 'user_id'=> Auth::user()->id])->first();
        // if($datas){
        //     return view('client.stemp.stemp', compact('datas'));
        // }
        // return redirect()->to('/')->withErrors(['error', 'Data Not Found!'])->with('error', 'Data Not Found!');
        $input = $request->all();
        $headers =[
            
        ];
        $user = Auth::user()->id;
        $id = $input['id'];
        $datas = Document::where(['user_id'=> Auth::user()->id,'id'=>$id])->first();
        // lemparan STEMTING
        /*
         {
            "certificatelevel": "NOT_CERTIFIED",
            "dest": "{{fileStamp}}",  //sumber file
            "docpass": "",
            "jwToken": "{{token}}",
            "location": "JAKARTA",
            "profileName": "emeteraicertificateSigner",
            "reason": "Akta Pejabat",
            "refToken": "{{serialNumber}}",
            "spesimenPath": "{{fileQr}}",
            "src": "{{file}}", // simpan disini setelah distemting
            "visLLX": 237,
            "visLLY": 559,
            "visURX": 337,
            "visURY": 459,
            "visSignaturePage": 1
        } 
         */
        //harusnya ambil dari database
        $data = [ 
            //data stempting
            "certificatelevel"=> "NOT_CERTIFIED",
            'dest'=> $datas->source ?? '',
            "docpass"=> "",
            "jwToken"=> Cookie::get('_token_ematerai'), //"{{token}}",
            "location"=> "JAKARTA",
            "profileName"=> "emeteraicertificateSigner",
            "reason"=> "Akta Pejabat",
            "refToken"=> $datas->sn,
            "spesimenPath"=>  '/docs/'.$datas->company->name.'/'.$datas->directory->name.'/spesimen/'.$datas->sn.'.png',//"{{fileQr}}",
            "src"=> '/docs/'.$datas->company->name.'/'.$datas->directory->name.'/out/'.$datas->filename ?? '0',
            'visLLX'=> $input['x1'] ?? '0',
            'visURX'=> $input['x2'] ?? '0',
            'visLLY'=> $input['y1'] ?? '0',
            'visURY'=> $input['y2'] ?? '0',
            'visSignaturePage' => $input['dokumen_page'] ?? '0',
        ];
        
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

       echo Cookie::get('_token_ematerai');
        $Url = config('sign-adapter.API_STEMPTING');
        // return response()->json($Url, 200, $headers);
      return  $stemting = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . Auth::user()->ematerai_token,
        ])->withBody(json_encode([
            "certificatelevel"=> "NOT_CERTIFIED",
            'dest'=>  '/docs/'.$datas->company->name.'/'.$datas->directory->name.'/out/'.$datas->filename, 
            "docpass"=> "",
            "jwToken"=> 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6Im1pdHJhY29tbTg3MzNfc3RnZW1ldEB5b3BtYWlsLmNvbSIsInN1YiI6IjYyYzdhYWY4MGQwOGE4MDAzNzM5MzUyNyIsImF1ZCI6Imh0dHBzOi8vZS1tZXRlcmFpLmNvLmlkIiwiaXNzIjoiZW1ldGVyYWkiLCJqdGkiOiJiMjgxMTNhMC0xOTY3LTRkMmQtYjljZS0zMjk1ODMzYjg0ZGMiLCJleHAiOjE3MDA3ODg4NjIsImlhdCI6MTcwMDcwMjQ2Mn0.BR9k5cRRd3JEEHCfvxWyd8uO97TjwP3LBr6bJ2OIioA',//Cookie::get('_token_ematerai'), //"{{token}}",
            "location"=> "JAKARTA",
            "profileName"=> "emeteraicertificateSigner",
            "reason"=> "Akta Pejabat",
            "refToken"=> $datas->sn,
            "spesimenPath"=> '/docs/'.$datas->company->name.'/'.$datas->directory->name.'/spesimen/'.$datas->sn.'.png',//"{{fileQr}}",
            "src"=> '/docs/'.$datas->company->name.'/'.$datas->directory->name.'/in/'.$datas->filename,
            'visLLX'=> $input['x1'] ?? '0',
            'visURX'=> $input['x2'] ?? '0',
            'visLLY'=> $input['y1'] ?? '0',
            'visURY'=> $input['y2'] ?? '0',
            'visSignaturePage' => $input['dokumen_page'] ?? '0',
        ]))->post($Url);
        // echo $stemting['status'];
        // dd($stemting);
        if($stemting){
            return response()->json($stemting, 200);
        }
        // return response()->json($result, 200, $headers);
        // return response()->json($stemting, 200);
        return response()->json(['test'=>$data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
   

}
