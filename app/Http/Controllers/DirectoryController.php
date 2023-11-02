<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Directory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas =  Directory::with('company')->get();
        return view("client.configure.directory.index", compact("datas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user()->id;
        $datas = Company::with('user')->find($user)->get();
        return view("client.configure.directory.index",compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $name = $input['company'];
        $category =  strtolower($input['name']);
        $path = public_path().'/docs/'.$name.'/'.$category.'/in';
        File::makeDirectory($path, $mode = 0777, true, true);
        $path = public_path().'/docs/'.$name.'/'.$category.'/out';
        File::makeDirectory($path, $mode = 0777, true, true);
        $path = public_path().'/docs/'.$name.'/'.$category.'/backup';
        File::makeDirectory($path, $mode = 0777, true, true);
        // Session::flash('message', 'Image are uploaded successfully');
        return redirect()->route('directory.index')->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Directory $directory)
    {
        $datas = Company::with('directory')->find($directory->id);
        // return Company::with('directory')->find($directory->id);
        return view("client.configure.directory.index", compact("datas"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Directory $directory)
    {
        //
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
