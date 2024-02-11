<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function Laravel\Prompts\password;

class UserController extends Controller
{
    //show register/create form
    public function create(){
        return view('users.register');
    }

    public function store(Request $request){
        $formFields=$request->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>['required','confirmed','min:6']
        ]);

        //Hash Password
        $formFields['password']=bcrypt($formFields['password']);

        // create user
        $user=User::create($formFields);

        auth()->login($user);

        return redirect('/')->with('success','User created and logged in');

        

    }

    //Logout user
    public function logout(Request $request){
        // removes auth info from the users session so that other requests are not authenticated
        //it is also recommended to invalidate the user's session and regenerate their csrf token
        auth()->logout();


        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        return redirect('/')->with('success','You have been logged out! FEILYA!!! FEILYA!!!');
    
    }

    //show login form
    public function login(){
        return view('users.login');
    }

    // authenticate user
    public function authenticate(Request $request){
        $formFields=$request->validate([
            'email'=>'required','email',
            'password'=>['required']
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('success','You are currently logged in');
        }

        return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');

    }

}
