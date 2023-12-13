<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        
        $attributes = $request->validate([
            'email' => ['required', 'email', 'min:15', 'max:255',  Rule::unique('users')->ignore(auth()->user()->id),],
        ]);

       auth()->user()->update([
           'email' => $request->get('email') ,
        ]);
        return back()->with('succes', 'Profile succesfully updated');
        // return back()->with('error', 'Your email does not match the email who requested the password change');
        
    }

    public function updatepassword(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'oldPassword' => 'required',
            'password' => ['required','confirmed',Password::min(6)->symbols()->numbers()],
            'password_confirmation' => 'required'
        ]);

        if (Hash::check($request->post('oldPassword'), Auth::user()->getAuthPassword())) {
            $paswordChange = User::find(auth()->user()->id);
            $paswordChange->about = 'password changed';
            $paswordChange->password = $input['password'];
            $paswordChange->update();
            $request->session()->invalidate();
            return redirect('profile')->with('success','Password changed successfully');
            //return redirect('/');
        }else{
            
            return redirect('profile')->withErrors('Current password incorrect.');
        }
    }
}
