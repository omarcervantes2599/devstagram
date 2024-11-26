@extends('layouts.app')

@section('titulo')
    Inicia sesion en DevsTagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{ asset('img/login.jpg') }}" alt="Imagen Registro de Usuarios">
        </div>
        <div class="md:w-4/12 bg-white rounded-lg shadow-xl p-6">
            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf
                @if (session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ session('mensaje') }}
                    </p>
                @endif
                <div class="md-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>
                    <input id="email" name="email" type="email" placeholder="Email"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value={{ old('email') }}>
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="md-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password
                    </label>
                    <input id="password" name="password" type="password" placeholder="Password de Registro"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <br>
                <div class="mb-5">
                  <input type="checkbox" name="remember"> 
                  <label class="text-agray-500 text-sm">Mantener sesion abierta</label>
                </div>
                <br>
                <input type="submit" value="Iniciar Sesion"
                    class="bg-sky-600 hover:bg-700 transition-colors rounded  -lg cursor-pointer uppercase	font-bold w-full p-3 text-white">
            </form>
        </div>
    </div>
@endsection
