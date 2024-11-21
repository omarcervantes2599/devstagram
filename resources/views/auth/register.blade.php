@extends('layouts.app')

@section('titulo')
    Registrarse en DevStagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center gap-10 md:items-center">
      <div class="md:w-6/12 p-5">
        <img src="{{asset('img/registrar.jpg')}}" alt="Imagen Registro de Usuarios">
      </div>
      <div class="md:w-4/12 bg-white rounded-lg shadow-xl p-6">
        <form>
          <div class="md-5">
            <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
              Nombre
            </label>
            <input 
              id="name"
              name="name"
              type="text"
              placeholder="Nombre"
              class="border p-3 w-full rounded-lg" 
            >
          </div>
          <div class="md-5">
            <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
              UserName
            </label>
            <input 
              id="username"
              name="username"
              type="text"
              placeholder="Nombre de Usuario"
              class="border p-3 w-full rounded-lg" 
            >
          </div>
          <div class="md-5">
            <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
              Email
            </label>
            <input 
              id="email"
              name="email "
              type="email"
              placeholder="Email"
              class="border p-3 w-full rounded-lg" 
            >
          </div>
          <div class="md-5">
            <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
              Password
            </label>
            <input 
              id="password"
              name="password"
              type="password"
              placeholder="Password de Registro"
              class="border p-3 w-full rounded-lg" 
            >
          </div>
          <div class="md-5">
            <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">
              Confirmar Password
            </label>
            <input 
              id="password_confirmation"
              name="password_confirmation"
              type="password"
              placeholder="Repite tu Password"
              class="border p-3 w-full rounded-lg" 
            >
          </div>
          <br>  
          <input 
            type="submit"
            value="Crear Cuenta"
            class="bg-sky-600 hover:bg-700 transition-colors rounded  -lg cursor-pointer uppercase	font-bold w-full p-3 text-white"
          >
        </form>
      </div>
    </div>
@endsection