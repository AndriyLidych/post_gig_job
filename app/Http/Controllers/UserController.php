<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //показ форми реєстрації та логіну
    public function create(){
        return view('users.register');
    }
    //створення юзера
    public function store(Request $request){
        $formFields= $request->validate([
            'name'=>['required'],
            'email'=>['required','email', Rule::unique('users','email')],
         'password'=>'required|confirmed'
        ]);

        //хешш паролів
        $formFields['password']= bcrypt($formFields['password']);
        $user=User::create($formFields);
        //логін
        auth()->login($user);
        return redirect('/')->with('message','User created and logged in');

    }
    // логаут
    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','You have been logged out');

    }
    //показ логін форми
    public function login(){
        return view('users.login');

    }
    //аутентифікація юзера
    public function authenticate(Request $request){
        $formFields= $request->validate([
            'name'=>['required'],
            'email'=>['required','email'],
            'password'=>'required'
        ]);
        if (auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You are now logged in ');
        }
        return back()->withErrors(['email'=>'incorrect'])->onlyInput('email');


    }
}
