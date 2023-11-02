<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $datas = Company::orderBy('id','DESC')->paginate(5);
        return view('client.configure.company.index',compact('datas'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
        // return view("client.configure.company.index");
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("client.configure.company.index");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $input = $request->all();
        // $Company = Company::where('name', request('name'))->first();
        $uniq = [
            'user_id'=>  Auth::user()->id,
            'name'=> $input['name'] 
        ];
        $data =[
        'detail' => $input['detail'],
        ];
        $Company = Company::updateOrCreate($uniq,$data);
        return redirect()->route('company.index')
        ->with('success','Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $data = $company;
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $data = $company;
        return view("client.configure.company.index",compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
