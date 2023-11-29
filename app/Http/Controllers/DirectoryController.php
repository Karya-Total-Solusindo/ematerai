<?php

namespace App\Http\Controllers;

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
use Illuminate\Database\Eloquent\Collection;

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
        // DB::getQueryLog();
        if($datas->count()){
            return view("client.configure.directory.index",compact('datas'));
        }
        return redirect()->route('company.index')->with('success','You have to create a company');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        //dd($input);
        $companyId = $input['company'];
        $company = Company::find($input['company'])->name;
        $this->validate($request, [
            'name' => 'required',
        ]);
        $uniq = [
            'company_id'=>  $companyId,
            'name'=> $input['name'],
            'active'=> 1,
        ];
        $data = [
            'user_id'=> Auth::user()->id,
            'active'=> 1,
            'template'=> $input['template'] ?? '0',
            'x1'=> $input['x1'] ?? '0',
            'x2'=> $input['x2'] ?? '0',
            'y1'=> $input['y1'] ?? '0',
            'y2'=> $input['y2'] ?? '0',
            'height' => $input['dokumen_height'] ?? '0',
            'width' => $input['dokumen_width'] ?? '0',
            'page' => $input['dokumen_page'] ?? '0',
        ];
        $Company = Directory::updateOrCreate($uniq,$data);

        $name =  strtolower($input['name']);
        $path = '/docs/'.$company.'/'.$name.'/in';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.$company.'/'.$name.'/out';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.$company.'/'.$name.'/backup';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.$company.'/'.$name.'/spesimen';
        Storage::disk('public')->makeDirectory($path);
        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
        // File::makeDirectory($path, $mode = 0777, true, true);
        // Session::flash('message', 'Image are uploaded successfully');
        return redirect()->route('directory.index')->with('success','created successfully');
    }
    public function upload(Request $request)
    {
        $input = $request->all();
        $file = $request->file('file');
        $fileName = str_replace('','_',$file->getClientOriginalName());
        $path = 'docs/'.$input['company_name'].'/'.$input['directory_name'].'/in';
        $file->move(public_path($path),$fileName);
        $companyId = $input['company'];
        $user = Auth::user()->id;
        $uniq = [
           
           
            // 'active'=> 1,
        ];
        $data = [ 
            'user_id'=>  $user,
            'company_id'=>  $companyId,
            'directory_id'=> $input['directory'],
            'active'=> 1,
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
        return response()->json(['success'=>$fileName]);
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
        $company = User::with('company')->where('id',$user)->get();
        $datas = Directory::where('id',$id)->get();
        if($datas->count()){
            return view("client.configure.directory.index",compact('directory','company'));
        }
        return redirect()->route('company.index')->with('success','You have to create a company');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Directory $directory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Directory $directory)
    {
        //
    }
}
