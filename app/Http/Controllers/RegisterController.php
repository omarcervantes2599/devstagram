<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        //modificar el request
        $request->request->add(['username' => Str::slug($request->username)]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'username' => 'required|unique:users|min:5|max:20',
            'email' => 'required|unique:users|email|min:5|max:60',
            'password' => 'required|min:6|max:50|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        // Auth::attempt([
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);       
        //redireccionar Muro
        Auth::attempt($request->only('email','password'));
        return redirect()->route('posts.index');
    }
}
