<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'index']]);
    }
    
    public function index(User $user)
    {
        $posts = Post::where('user_id',$user->id)->paginate(20);
       
        return view('dashboard', [
            'user' => $user,
            'posts'=> $posts
        ]);
    }
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => Auth::user()->id,
        // ]);

        // Otra Forma
        // $post = new Post;
        // $post->titulo= $request->titulo;
        // $post->descripcion= $request->descripcion;
        // $post->imagen= $request->imagen;
        // $post->user_id= Auth::user()->id;
        // $post->save();

        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->route('posts.index', Auth::user()->username);

    }

    public function show(User $user,Post $post)
    {
        return view('posts.show',[
            'user' => $user,
            'post' => $post
        ]);
    }

    public function destroy(Post $post)
    {
     Gate::authorize('delete',$post);
     $post->delete();
        //Eliminar la imagen
        $imagen_path = public_path('uploads/'. $post->imagen);
        if(File::exists($imagen_path)){
            unlink($imagen_path);

        }
     return redirect()->route('posts.index', Auth::user()->username);
    }
}
