<?php

namespace App\Http\Controllers;


use App\Adapter\SignAdapter;
use App\Models\Company;
use App\Models\Directory;
use App\Models\Document;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $datas =  Directory::with('user')->find(1)->get('company_id');
        $user = Auth::user()->id;
        if (($s = $request->s)) {
            $datas =  Directory::where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->Where('user_id','=',Auth::user()->id)
                            ->get();
                    }
                }]
            ])->with('company')->paginate(5);
        }else{
            $datas =  Directory::with('company')->where('user_id','=',Auth::user()->id)->paginate(5);
        }
        return view("client.configure.directory.index", compact("datas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        DB::enableQueryLog();
        $user = Auth::user()->id;
        // return $datas = User::with('company')->find($user)->get('*');
        $datas =  Company::where('user_id',$user)->get();
        $jenisdocument = SignAdapter::getJenisDocument();
        // DB::getQueryLog();
        if($datas->count()){
            return view("client.configure.directory.index",compact(['datas','jenisdocument']));
        }
        return redirect()->route('company.index')->with('error','You have to create a company first');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        $request->validate([
            'name'=> 'required|min:3',
            //'name'=> ['required','regex:/^([A-Z0-9-_ ]+)$/s']
        ]);
        preg_match('/^([A-Z0-9-_ ]+)$/s', strtoupper($input['name']), $matches,PREG_OFFSET_CAPTURE, 0);
        if($matches==false){
            return redirect()->route('directory.create')->with('error','wrong input on Directory name');
        }
        $companyId = $input['company'];
        $company = Company::find($input['company'])->name;
        $this->validate($request, [
            'name' => 'required',
            'template' => 'required',
            'file' => 'required',
            // 'lower_left_x' => 'required',
            // 'lower_left_y' => 'required',
            // 'lower_right_x' => 'required',
            // 'upper_right_y' => 'required',
        ]);
        $uniq = [
            'company_id'=>  $companyId,
            'name'=> Str::upper($input['name']),
            'active'=> 1,
        ];
        $data = [
            'user_id'=> Auth::user()->id,
            'active'=> 1,
            'template'=> $input['template'] ?? '0',
            // 'x1'=> $input['x1'] ?? '0',
            // 'x2'=> $input['x2'] ?? '0',
            // 'y1'=> $input['y1'] ?? '0',
            // 'y2'=> $input['y2'] ?? '0',
            'x1'=> $input['lower_left_x'] ?? '0',
            'y1'=> $input['lower_left_y'] ?? '0',
            'x2'=> $input['upper_right_x'] ?? '0',
            'y2'=> $input['upper_right_y'] ?? '0',
            'height' => $input['dokumen_height'] ?? '0',
            'width' => $input['dokumen_width'] ?? '0',
            'page' => $input['dokumen_page'] ?? '0',
        ];

        $Company = Directory::updateOrCreate($uniq,$data);
        $name =  strtoupper($input['name']);
        $path = '/docs/'.Str::upper($company).'/'.Str::upper($name).'/in';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.Str::upper($company).'/'.Str::upper($name).'/out';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.Str::upper($company).'/'.Str::upper($name).'/backup';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.Str::upper($company).'/'.Str::upper($name).'/spesimen';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        //upload template
        $file = $request->file('file');
        $fileName = str_replace('','_','template_'.Str::upper($company).'__'.Str::upper($name).'.pdf');//$file->getClientOriginalName());
        $templatepath = '/app/public/docs/'.Str::upper($company).'/'.Str::upper($name).'/';
        $file->move(storage_path($templatepath),$fileName);
        // File::makeDirectory($path, $mode = 0777, true, true);
        // Session::flash('message', 'Image are uploaded successfully');
        return redirect()->route('directory.index')->with('success','created successfully');
    }
    public function upload(Request $request)
    {
        //multipel upload for ajax 
        $input = $request->all();
        $directorys = Directory::where('id',$input['directory']);
        $directory = $directorys->first();
        $file = $request->file('file');

        if($file->getMimeType() != 'application/pdf'){
            return response()->json(['error'=>'File type disallow']); 
        }
        if($directorys->get()->count()==1){
            $file = $request->file('file');
            // set filename
            // space to underscore 
            // intercept uppercase to lowercase extension   
            $fileName = str_replace(' ','_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.pdf');
            // set path upload to /in directory
            $path = '/app/public/docs/'.Str::upper($directory->company->name).'/'.Str::upper($directory->name).'/in/';
            if (File::exists(storage_path($path).$fileName)) {
                return response()->json(['error'=>'file exists','message'=>"file exists ".$path.$fileName]);   
            }

            //dd(storage_path($path).$fileName,File::exists($path.$fileName));
            $file->move(storage_path($path),$fileName);
            $companyId = $input['company'];
            $user = Auth::user()->id;
            $uniq = [
                // 'active'=> 1,
            ];
            $data = [ 
                'user_id'=>  $user,
                'company_id'=>  $companyId,
                'directory_id'=> $input['directory'],
                'docnumber'=> Str::uuid(),
                'active'=> 1,
                'source'=> '/docs/'.Str::upper($directory->company->name).'/'.Str::upper($directory->name).'/in/'.$fileName ?? '0',
                'x1'=> $input['x1'] ?? '0',
                'x2'=> $input['x2'] ?? '0',
                'y1'=> $input['y1'] ?? '0',
                'y2'=> $input['y2'] ?? '0',
                'height' => $input['dokumen_height'] ?? '0',
                'width' => $input['dokumen_width'] ?? '0',
                'page' => $input['dokumen_page'] ?? '0',
                'filename' => $input['filename'] ?? '0',
                'certificatelevel' => 'NEW'
                
            ];
            $fileUpload =  Document::Create($data);
            $fileUpload->filename = $fileName;
            $fileUpload->save();
            return response()->json(['success'=>$fileName,'path'=> $path.'/'.$fileName,'directory'=>$directory]);
            }
            return response()->json(['error'=>'No Directory']);    
    }

    /**
     * Display the specified resource.
     */
    public function show(Directory $directory)
    {
        $datas = Directory::with('company')->find($directory->id)->where('id',$directory->id)->get();
        // Company::with('directory')->find($directory->id);
        return view("client.configure.directory.index", compact("datas"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Directory $directory)
    {
        $user = Auth::user()->id;
        $id = $directory->id;
        $datas = Directory::where('id',$id)->first();
        $company = User::with('company')->where('id',$user)->first();
        $templatefile = Str::upper($datas->company->name).'__'.Str::upper($datas->name).'.pdf';
        $templatepath =  'storage/docs/'.Str::upper($datas->company->name).'/'.Str::upper($datas->name).'/'.'template_'.$templatefile;
        $fileThemp = false;
        if (File::exists(public_path($templatepath))){
            // untuk diset di showPDF({{ }});
            $fileThemp = url($templatepath);
        }
        $jenisdocument = SignAdapter::getJenisDocument();
        if($datas->count()){
            return view("client.configure.directory.index",compact('datas','directory','company','fileThemp','jenisdocument'));
        }
        return redirect()->route('company.index')->with('success','You have to create a company');
    }


    /**
     * Show the form for editing the specified resource. backup
     */
    // public function edit(Directory $directory)
    // {
    //     $user = Auth::user()->id;
    //     $id = $directory->id;
    //     $company = User::with('company')->where('id',$user)->get();
    //     $datas = Directory::where('id',$id)->get();
    //     if($datas->count()){
    //         return view("client.configure.directory.index",compact('directory','company'));
    //     }
    //     return redirect()->route('company.index')->with('success','You have to create a company');
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Directory $directory)
    {
        $input = $request->all();
        //dd($input);
        //$companyId = $input['company'];
        $company = Company::find($directory->company_id)->name;
        $input['name']= $directory->name;
      $this->validate($request, [
            // 'name' => 'required',
            'template' => 'required',
            // 'lower_left_x' => 'required',
            // 'lower_left_y' => 'required',
            // 'lower_right_x' => 'required',
            // 'upper_right_y' => 'required',
        ]);
        // dd($directory);
        $uniq = [
            'company_id'=>  $directory->company_id,
            'name'=> $directory->name,
            'active'=> 1,
        ];

       
        $data = [
            'user_id'=> Auth::user()->id,
            'active'=> 1,
            'template'=> $input['template'] ?? '0',
            // 'x1'=> $input['x1'] ?? '0',
            // 'x2'=> $input['x2'] ?? '0',
            // 'y1'=> $input['y1'] ?? '0',
            // 'y2'=> $input['y2'] ?? '0',
            'x1'=> $input['lower_left_x'] ?? '0',
            'y1'=> $input['lower_left_y'] ?? '0',
            'x2'=> $input['upper_right_x'] ?? '0',
            'y2'=> $input['upper_right_y'] ?? '0',
            'height' => $input['dokumen_height'] ?? '0',
            'width' => $input['dokumen_width'] ?? '0',
            'page' => $input['dokumen_page'] ?? '0',
        ];

        // $Company = Directory::update([$data]);
        $directory->update($data);
        
        $name =  strtoupper($input['name']);
        $path = '/docs/'.Str::upper($company).'/'.Str::upper($name).'/in';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.Str::upper($company).'/'.Str::upper($name).'/out';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.Str::upper($company).'/'.Str::upper($name).'/backup';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.Str::upper($company).'/'.Str::upper($name).'/spesimen';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        //upload template
        $file = $request->file('file');
        if($file){
            $fileName = str_replace('','_','template_'.Str::upper($company).'__'.Str::upper($name).'.pdf');//$file->getClientOriginalName());
            $templatepath = '/app/public/docs/'.Str::upper($company).'/'.Str::upper($name).'/';
            $file->move(storage_path($templatepath),$fileName);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        // Session::flash('message', 'Image are uploaded successfully');
        return redirect()->route('directory.index')->with('success','update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Directory $directory)
    {
        //
    }

}
