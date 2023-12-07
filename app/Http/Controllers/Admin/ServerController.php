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
    public function phpinfo()
    {
        phpinfo();
    }
}
