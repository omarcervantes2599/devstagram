<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function index( User $user){
        return view('dashboard',[
            'user'=> $user,
        ]);
   }
   public function create()
   {
        return view('posts.create');
   }
    
}
