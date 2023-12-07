<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Contracts\Role;

class FileManagerController extends Controller
{
    public function index(){
        if(auth()->user()->hasRole('Admin')){
            return view('admin.filemanager');
        }
        return abort(404);
    }
}
