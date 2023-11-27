<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Directory;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //user data
        $user_id = Auth::user()->id;
        $companies = Company::where('user_id',$user_id)->orderBy('created_at', 'desc')->get();
        // return
        // return view('client.document.upload.multiple'); // source path
        return view('client.document.index', compact('companies'));
    }

    public function getDirectory(Company $company)
    {
        $request = Request()  ;//?option&ids=1
        $directorys = Directory::where('company_id',$company->id)->get();
        echo "<option value=''>Select one</option>";
        foreach ($directorys as $value) {
            echo "<option value='".$value['id']."'>".$value['name']."</option>";
        }
        exit;
        $format =  $request->getQueryString();
        if($format=='option='){
           
        }
        echo http_build_query($request->query()); 
        dd($format);
        return response()->json($directorys);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $input = $request->all();
        $request->validate([
            'company' => 'required',
            'directory' => 'required',
            'title' => 'required',
            'number' => 'required',
            'amount' => 'required',
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);
        //dd($request->pdf);
        $company = Company::find($input['company']);
        $company->where('user_id',$user_id)->get('name');

        $directory = Directory::find($input['directory']);
        $directory->where('user_id',$user_id)
                  ->where('company_id',$input['company'])->get('name');
        $filePath = ('/docs/'.$directory->company->name.'/'.$directory->name.'/in/');
        $file = $request->file('pdf'); 
        $fileName = str_replace('','_',$file->getClientOriginalName());
        $path = Storage::disk('public')->put($filePath.$fileName,file_get_contents($request->pdf));
        $document =[
            'user_id'=> Auth::user()->id,
            'active'=> 1,
            // 'template'=> $input['template'] ?? '0',
            'company_id'=> $directory->company->id ?? '0',
            'directory_id'=> $directory->id ?? '0',
            'docnumber' => $input['number'],
            'x1'=> $input['x1'] ?? '0',
            'x2'=> $input['x2'] ?? '0',
            'y1'=> $input['y1'] ?? '0',
            'y2'=> $input['y2'] ?? '0',
            'height' => $input['dokumen_height'] ?? '0',
            'width' => $input['dokumen_width'] ?? '0',
            'page' => $input['dokumen_page'] ?? '0',
            'filename' => $fileName ?? '0',
            'source'=> $path
        ];
        $inset = Document::create($document);
        $insertId = $inset->id;
        //set data from Database
        $result = "<tr><td class='ps-0'> <input type='checkbox' value='".$insertId."' name='doc[]' class='ps-0 chechList'> </td><td>".$input['title']."</td><td>".$input['number']."</td><td>".$input['amount']."</td><td><a target='_blank' href='".url('storage/'.$filePath.$fileName)."'><i class='fas fa-file-pdf'></i></a>  ".$fileName."</td></tr>";
        $status = true;
        if($status){
            $messeage = [
                'success' => true,
                'extension'=> $request->pdf->extension(),
                'message'=> '<b>'.$input['title']."<b><br> File uploaded successfully!",
                'test' => $company,
                'path'=>$filePath.$fileName,
                'result' => $result 
            ];
        }else{
            $messeage = [
                'success' => false,
                'extension'=> $request->pdf->extension(),
                'message'=> '<b>'.$input['title']."</b><br> File failed to upload!",
            ];
        }
        
        return response()->json($messeage);
        // $response = response('File contents', 200, [
        //     'Content-Type' => 'application/json',
        //     'Content-Disposition' => 'attachment; filename="myfile.txt"',
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json(['message'=>$request]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
