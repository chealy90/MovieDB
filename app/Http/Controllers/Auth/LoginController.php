<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function index(){
        return view('loginAndRegister.login');
    }


    public function login(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            // If successful, redirect to the intended page or home page
            return redirect()->intended('/movies');
        } else {
            // If login fails, redirect back with an error message
            return Redirect::back()->withErrors(['email' => 'Invalid credentials.']);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/movies');
    }
}
