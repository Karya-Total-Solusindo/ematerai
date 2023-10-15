<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            // 'email' => ['required', 'email'],
            'username' => ['required'],
            'password' => ['required'],
        ]);


        $login = $request->input('username');
        $user = User::where('email', $login)->orWhere('username', $login)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['username' => 'Invalid login credentials']);
        }
        $remember =  $request->remember ? true : false;
        // Login using email or username
        if (Auth::attempt(['email' => $user->email, 'password' => $request->password],$remember)
        || Auth::attempt(['username'=> $user->username,'password' => $request->password],$remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        if(!Auth::validate($credentials)):
            return redirect()->to('login')->withErrors(trans('auth.login'));
        endif;
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
