<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComentarioController extends Controller
{
  public function store(Request $request, User $user, Post $post)
  {
    //validar

    $validator = Validator::make($request->all(), [
      'comentario' => 'required|max:255'
    ]);

    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }
    //almacenar el resultado
    Comentario::create([
      'user_id' => Auth::user()->id,
      'post_id' => $post->id,
      'comentario' => $request->comentario,
    ]);

    //imprimir un mensaje

    return back()->with('mensaje','Comentario Realizado Correctamente');
  }
}
