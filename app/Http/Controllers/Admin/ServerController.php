<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        // $this->middleware('permission:server-list|server-create|server-edit|server-delete', ['only' => ['index','store']]);
        // $this->middleware('permission:server-create', ['only' => ['create','store']]);
        // $this->middleware('permission:server-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:server-delete', ['only' => ['destroy']]);
        $this->middleware('permission:phpinfo', ['only' => ['phpinfo']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function phpinfo()
    {
        phpinfo();
    }
    # super admin docs akses
    public function docs()
    {
        phpinfo();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
