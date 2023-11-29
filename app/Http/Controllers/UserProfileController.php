<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        
        $attributes = $request->validate([
            'email' => ['required', 'email', 'min:20', 'max:255',  Rule::unique('users')->ignore(auth()->user()->id),],
        ]);

       auth()->user()->update([
           'email' => $request->get('email') ,
        ]);
        return back()->with('succes', 'Profile succesfully updated');
        // return back()->with('error', 'Your email does not match the email who requested the password change');
        
    }

    public function updatepassword(Request $request)
    {
        
        $attributes = $request->validate([
            'oldPassword' => ['required'],
            'newPassword' => ['required','confirmed', 'min:6'],
            'confPassword' => ['same:newPassword']
        ]);
        dd($attributes);
        $existingUser = auth()->user()->where('email', $attributes['email'])->first();
        if ($existingUser) {
            // true change
            $existingUser->update([
                'password' => $attributes['password']
            ]);
           // return redirect('login');
        } else {
           // return back()->with('error', 'Your email does not match the email who requested the password change');
        }
    }
}
