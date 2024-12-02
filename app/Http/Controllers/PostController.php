<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            //new Middleware('auth', only: ['create']),
        ];
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
}
