<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //Validar password
        if(!Auth::attempt($request->only('email','password'),$request->remember))
        {
            return back()->with('mensaje','Credenciales incorrectas');
        }
        //Reescribes el nuevo password
        return redirect()->route('posts.index', Auth::user()->username);
    }
}
