<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Company;
use App\Models\Directory;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Adapter\SignAdapter;

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
    public function create(Directory $directory)
    {

        //user data
        $user_id = Auth::user()->id;
        $directorys = Directory::select('directories.*','companies.name as companyName')
        ->where('directories.id','=',$directory->id)
        ->where('directories.user_id','=',$user_id)
        ->join('companies','companies.id','=','directories.company_id')      
        ->first();
        if($directorys){
            return view('client.document.index', compact('directorys'));
        }
        return redirect()->route('company')->with('error', 'No Directory');
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
        $fileName = str_replace(' ','_',$file->getClientOriginalName());
        $file_path = $filePath.$fileName;
        //Check File is exists
        if (Storage::disk('public')->exists($file_path)) {
            $messeage = [
                'success' => false,
                'extension'=> $request->pdf->extension(),
                'message'=> '<b>'.$file->getClientOriginalName()."<br> is  exists,  please upload another file or rename the file! </b><br>",
            ];
            // return response()->json($messeage);
        }
       
        
        $path = Storage::disk('public')->put($filePath.$fileName,file_get_contents($request->pdf));
        $document =[
            'user_id'=> Auth::user()->id,
            'active'=> 1,
            // 'template'=> $input['template'] ?? '0',
            'company_id'=> $directory->company->id ?? '0',
            'directory_id'=> $directory->id ?? '0',
            'docnumber' => $input['number'],
             //get coordinate from template (table directory)
            'x1'=> $directory->x1 ?? '0',
            'x2'=> $directory->x2 ?? '0',
            'y1'=> $directory->y1 ?? '0',
            'y2'=> $directory->y2 ?? '0',
            'height' => $input['dokumen_height'] ?? '0',
            'width' => $input['dokumen_width'] ?? '0',
            'page' => $input['dokumen_page'] ?? '0',
            'filename' => $fileName ?? '0',
            'source'=> $filePath.$fileName
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
                'path'=> $filePath.$fileName,
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

    public function getSerialNumberBatch(Request $request){
        //$test  = SignAdapter::getBatchSerial('sds');
        $input = $request->all();
        // dd($request->all());
        return SignAdapter::getBatchSerial($input['doc']);
    }

    /**TODO update status  tu INPROGRESS 
     *  certificatelevel
    */
    public function setInProgres(Request $request){
        $document_id = $request->post('doc');
        // dd($document_id);
        $countSuccess = 0; 
        $CountError = 0; 
        foreach ($document_id as $id) {
                $document = Document::where('id',$id)
                ->update(['certificatelevel' => 'INPROGRESS']);
                if($document){
                    $countSuccess++;
                }else{
                    $CountError++;
                }

            }
        return redirect()->back()->with('success','The document was successfully sent in the processing queue.<br> 
        Success: '.$countSuccess.'<br> Failed: '.$CountError);        
    }

    public function getSerialNumber(Request $request){
        $input = $request->all();
        return SignAdapter::getSerial($input['doc']);
    }

    public function stampExecute(Request $request){
        $input = $request->all();
        return SignAdapter::exeSreialStamp($input['doc']);
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
