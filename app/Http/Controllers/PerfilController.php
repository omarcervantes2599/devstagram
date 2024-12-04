<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }
    public function store(Request $request)
    {
        $request->request->add(['username' => Str::slug($request->username)]);
        $rules = [
            'username' => ['required', 'unique:users,username,' . Auth::user()->id, 'min:5', 'max:20', 'not_in:twitter,admindev'],
            'email' => ['required', 'unique:users,email,' . Auth::user()->id, 'email', 'min:5', 'max:60'],
            'new_password' => ['nullable', 'min:3', 'max:50'], // Solo validar si se ingresa
        ];

        if ($request->filled('new_password')) {
            $rules['password'] = ['required'];
        }

        $this->validate($request, $rules);

        // Validar el password actual solo si se ingresa un nuevo password
        if ($request->filled('new_password') && !Hash::check($request->password, Auth::user()->password)) {
            return back()->with('mensaje', 'Password actual incorrecto');
        }

        if ($request->imagen) {
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $manager = new ImageManager(new Driver());
            $imagenServidor = $manager::imagick()->read($imagen);
            $ancho = 1000;
            $alto = 1000;

            // Calcula las coordenadas iniciales para centrar el recorte
            $x = ($imagenServidor->width() / 2) - ($ancho / 2);
            $y = ($imagenServidor->height() / 2) - ($alto / 2);

            // Realiza el recorte desde el centro
            $imagenServidor->crop($ancho, $alto, $x, $y);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Guardar cambios
        $usuario = User::find(Auth::user()->id);
        $usuario->username = $request->username;
        $usuario->email = $request->email;

        // Si el usuario ingresó una nueva contraseña, actualízala
        if ($request->new_password) {
            $usuario->password = Hash::make($request->new_password);
        }

        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? '';
        $usuario->save();

        //Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
