<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  public function __invoke()
{
    if (!Auth::check()) {
        return redirect()->route('login'); // O manejar el caso según tu lógica.
    }

    // Obtener a quienes seguimos
    $ids = Auth::user()->followings->pluck('id')->toArray();
    $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

    return view('home', [
        'posts' => $posts
    ]);
}

}
