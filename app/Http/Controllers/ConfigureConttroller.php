<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;


class ConfigureConttroller extends Controller
{
    function __construct()
    {
        $this->middleware('permission:configure-list|configure-create|configure-edit|configure-delete', ['only' => ['index','store']]);
        $this->middleware('permission:configure-create', ['only' => ['create','store']]);
        $this->middleware('permission:configure-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:configure-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view("client.configure.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("client.configure.index");
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'category' => 'required'
        // ]);
        $input = $request->all();
        $name = $input['name'];
        $category =  strtolower($input['category']);
        $path = '/docs/'.$name.'/'.$category.'/in';
        Storage::disk('public')->makeDirectory($path);
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.$name.'/'.$category.'/out';
        Storage::disk('public')->makeDirectory($path);
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.$name.'/'.$category.'/backup';
        Storage::disk('public')->makeDirectory($path);
        // File::makeDirectory($path, $mode = 0777, true, true);
        $path = '/docs/'.$name.'/'.$category.'/spesimen';
        Storage::disk('public')->makeDirectory($path);
        // File::makeDirectory($path, $mode = 0777, true, true);
        // Session::flash('message', 'Image are uploaded successfully');
        return redirect()->route('configure')->with('success','Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
