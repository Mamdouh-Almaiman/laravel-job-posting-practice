<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // Show register/create form
    public function create()
    {
        return view('users.register');
    }

    //Create new user
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')], // users = table, email = column
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        // Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        //Create user
        $user = User::create($formFields);
        // As we did for listing, User here is the model and create is the method

        //Login
        Auth::login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }


    // Logout user
    public function logout(Request $request)
    {
        Auth::logout(); // this will remove the authentication info from the user session

        // It's recommeded that we invalid the user session and regenerate thier csrf token, and this is how to do it:
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
    }


    // Show login form
    public function login()
    {
        return view('users.login');
    }


    // Authenticate user
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if (Auth::attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email'); // So if there is error to logging in the error message will show under the email field only
    }
}
