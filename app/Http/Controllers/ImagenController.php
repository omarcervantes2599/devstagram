<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

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

        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);



        return response()->json([
            'imagen' => $nombreImagen,
        ]);
    }
}
